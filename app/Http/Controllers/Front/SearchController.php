<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $filters = $request->all();
        $query = Product::query();

        if (isset($filters['keyWord']) and $filters['keyWord'] != '') {
            $query->where('name', 'like', '%' . $filters['keyWord'] . '%');
        }
        if (isset($filters['productNumber']) and $filters['keyWord'] != '') {
            $query->where('pro_number', $filters['productNumber']);
        }
        if (isset($filters['keyWord']) and $filters['keyWord'] != '') {
            $query->where('category_id', $request->category);
        }
        if (isset($filters['keyWord']) and $filters['keyWord'] != '') {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        $products = $query->get();

        if($request->ajax()){
            return response()->json($products);

        } else{
            dd();
        }

    }

}
