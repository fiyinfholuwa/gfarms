<?php

namespace App\Http\Controllers;

use App\Models\FoodReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodReviewController extends Controller
{
    public function store(Request $request, $foodId)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'You must be logged in to post a review.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        FoodReview::create([
            'food_id' => $foodId,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->back()->with('success', 'Your review has been posted successfully!');
    }
}
