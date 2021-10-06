<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    use HasFactory;
    // protected $primaryKey = 'products_id';

    // public $incrementing = false;

    // protected $keyType = 'string';

    protected $fillable = [
        'image', 'products_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }

    public function getImageAttribute($image)
    {
        return asset('storage/' . $image);
    }
}
