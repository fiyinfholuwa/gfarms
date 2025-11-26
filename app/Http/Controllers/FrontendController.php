<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\View\View;


class FrontendController extends Controller
{
    public function home():View{
        $products = Food::all();
        $categories = Category::orderBy('name')->get();
        return view('frontend.home', compact('products', 'categories'));
    }
    public function contact():View{
        return view('frontend.contact');
    }
    public function shop(Request $request):View{
        $query = Food::query();

        // 🔍 Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%")
                  ->orWhere('short_description', 'LIKE', "%{$search}%");
        }

        // 🗂 Category filter (if you click category filter button)
        if ($request->filled('category')) {
            $category = $request->input('category');
            $query->where('category', $category);
        }

        // 🕒 Sorting (optional dropdown)
        if ($request->filled('orderby')) {
            switch ($request->orderby) {
                case 'date':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'price':
                    $query->orderByRaw('CAST(amount AS DECIMAL(10,2)) asc');
                    break;
                case 'price-desc':
                    $query->orderByRaw('CAST(amount AS DECIMAL(10,2)) desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::orderBy('id')->get();

        return view('frontend.shop', compact('products', 'categories'));    }
    public function about():View{
        return view('frontend.about');
    }


    public function policy(){
        return view('frontend.policy');
    }
    public function t_c(){
        return view('frontend.t_c');
    }
    public function shop_detail($name){

        
        $food = Food::where('slug', $name)->first(); 
        $foods = Food::paginate(6);
        return view('frontend.shop_details', compact('food', 'foods'));
    }
}
