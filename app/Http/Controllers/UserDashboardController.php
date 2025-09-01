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
        $categories = Category::withCount('foods')->get();
        $foods = Food::all(); // Get all available foods
        return view('user.packages', compact('foods', 'categories'));
    }
    public function food_category($name){
        $category = Category::where('category_url', '=', $name)->first();
        $foods = Food::where('category', $category->id)->get(); // Get all available foods
        return view('user.food_category', compact('foods', 'category'));
    }
    public function my_cart(){
        $carts = Cart::where('user_id', '=', Auth::user()->id)->get();
        return view('user.cart', compact('carts'));
    }

    public function search_food(Request $request)
{
    $query = $request->input('query');

    $foods = Food::when($query, function ($q) use ($query) {
        $q->where('name', 'LIKE', '%' . $query . '%');
    })->get();

    return view('user.food_search', compact('foods', 'query'));
}

}
