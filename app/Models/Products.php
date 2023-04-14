<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'thumbnail',
        'sale_price',
        'category',
        'brand',
        'upsell_items',
        'crosssell_items',
        'stock',
        'gallery_images',
    ];

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }
}
