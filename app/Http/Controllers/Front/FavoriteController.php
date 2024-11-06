<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class FavoriteController extends Controller
{
    public function show(Product $product, Favorite $favorites){
        $favoriteItems = '';

        if($favorites){
            $favorites = Arr::flatten(session('favorite'));
            $favorites = array_unique($favorites);
            $favoriteItems = Product::whereIn('id', $favorites)->get();
        }
        return view('front.favorite', compact('favoriteItems'));
    }

    public function add(Favorite $favorite){
        $productId = request('id');
        $favorite->add($productId);
        return response()->json(['status' => 'added']);
    }

    public function delete(Favorite $favorite){
        $productId = request('id');
        $favorite->delete($productId);
        return response()->json(['status' => 'deleted']);
    }

    public function clear(Favorite $favorite){
        $favorite->clear();
        return redirect(route('favorite'))->with('success', 'Xóa yêu thích thành công.');
    }

}
