<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];

    public function foods()
{
    return $this->hasMany(Food::class, 'category', 'id');
}

}
