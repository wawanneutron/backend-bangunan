<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id', 'invoice', 'product_id', 'product_name', 'image', 'qty', 'unit', 'price'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function gallery()
    {
        return $this->belongsTo(ProductGallery::class, 'product_id', 'products_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
