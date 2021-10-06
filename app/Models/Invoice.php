<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice', 'customer_id', 'courier', 'service', 'cost_courier', 'weight',
        'name', 'phone', 'province', 'city', 'address', 'note', 'status', 'resi', 'snap_token', 'grand_total'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function provinsi()
    {
        return $this->belongsTo(Province::class, 'province', 'province_id');
    }

    public function kota()
    {
        return $this->belongsTo(City::class, 'city', 'city_id');
    }

    public function gallery()
    {
        return $this->belongsTo(ProductGallery::class, 'id');
    }
}
