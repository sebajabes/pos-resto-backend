<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'image',
        'price',
        'stock',
        'status',
        'is_favorite',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
