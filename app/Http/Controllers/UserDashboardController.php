<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function browse(){
        $foods = Food::all(); // Get all available foods
        return view('user.packages', compact('foods'));
    }
}
