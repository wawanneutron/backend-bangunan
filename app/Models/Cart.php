<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'customer_id', 'quantity',
        'price', 'price_before', 'weight'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function gallery()
    {
        return $this->belongsTo(ProductGallery::class, 'product_id', 'products_id');
    }
}
