<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $filters = $request->all();

        $keyWord =  isset($filters['keyWord']) ? trim($filters['keyWord']) : '';
        $Category =  isset($filters['Category']) ? trim($filters['Category']) : '';
        $productNumber =  isset($filters['productNumber']) ? trim($filters['productNumber']) : '';
        $minPrice =  isset($filters['minPrice']) ? trim($filters['minPrice']) : '';
        $maxPrice =  isset($filters['maxPrice']) ? trim($filters['maxPrice']) : '';

        $conditions = [
            'keyWord' => $keyWord,
            'Category' => $Category,
            'productNumber' => $productNumber,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice
        ];
        
        $conditionString = '';
        $conditionArray = [];
        foreach($conditions as $condition => $value){
            $conditionString .= $condition.'='.$value.'&';
            $conditionArray[$condition] = $value;
        }
        session(['searchConditions' => $conditionArray]);

        $cacheKey = 'search:' . md5(strtolower($conditionString));

        $results = [];

        // Kiểm tra tồn tại của từ khóa trong cache Redis, nếu có sẽ sử dụng value đó 
        if (Cache::has($cacheKey)) {
            $results = Cache::get($cacheKey);

        }else{
            // nếu chưa có trong cache redis, query thường
            $query = Product::query();
            if (!empty($keyWord)) {
                $query->where('name', 'like', '%' . $keyWord . '%');
            }
            if (!empty($Category)) {
                $query->where('category_id', $Category);
            }
            if (!empty($productNumber)) {
                $query->where('pro_number', $productNumber);
            }
            if (!empty($minPrice)) {
                $query->where('price','>=', $minPrice);
            }
            if (!empty($maxPrice)) {
                $query->where('price','<=', $maxPrice);
            }

            $results = $query->get();
            Cache::put($cacheKey, json_encode($results), now()->addMinutes(2));
        }

        if(!is_array($results)){
            $results = json_decode($results, true);
        }

        if($request->ajax()){
            return response()->json($results);

        } else{
            // Chuyển mảng kết quả thành Collection và phân trang
            $results = new Collection($results);
            $perPage = 10;
            $page = $request->get('page', 1); // Lấy số trang hiện tại từ query string
            $paginatedResults = $results->forPage($page, $perPage); // Phân trang mảng kết quả

            // Tính tổng số trang
            $total = $results->count();
            $paginatedResults = new LengthAwarePaginator(
                $paginatedResults,
                $total,
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()] // Giữ các tham số query khi phân trang
            );
            return view('front.search-results')->with(['results' => $paginatedResults]);
        }
    }

    public function search_reset(Request $request) 
    {
        session(['searchConditions' => []]); 
        return response()->json(['status' => 'OK']);
    }
}
