<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function browse(){
        $foods = Food::all();
        return view('user_new.shop', compact('foods'));
    }
    public function category(){
        $categories = Category::withCount('foods')->get();
        return view('user_new.category', compact('categories'));
    }
    public function food_category($name){
        $category = Category::where('category_url', '=', $name)->first();
        $foods = Food::where('category', $category->id)->get(); // Get all available foods
        return view('user_new.shop_category', compact('foods', 'category'));
    }
    public function shop_detail($name){
        $food = Food::where('slug', $name)->first(); 
        return view('user_new.shop_detail', compact('food'));
    }
    public function my_cart(){
        $carts = Cart::where('user_id', '=', Auth::user()->id)->get();
        return view('user_new.cart', compact('carts'));
    }

    public function search_food(Request $request)
{
    $query = $request->input('query');

    $foods = Food::when($query, function ($q) use ($query) {
        $q->where('name', 'LIKE', '%' . $query . '%');
    })->get();

    return view('user_new.shop_search', compact('foods', 'query'));
}

}
