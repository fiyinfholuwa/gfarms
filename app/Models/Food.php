<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods'; // ✅ Make sure it matches your migration

    protected $fillable = [
        'name', 'category', 'slug', 'image', 'short_description', 'full_description', 'amount'
    ];

    public function cat()
    {
        return $this->hasOne(Category::class, 'id', 'category');
    }

    public function categoryInfo()
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }

    public function reviews()
{
    return $this->hasMany(\App\Models\FoodReview::class);
}

}
