<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'name',
      'lastname',
      'email',
      'phone',
      'shipment',
      'privacy',
      'payed',
      'processed',
      'total'
    ];

    public function products()
    {
        //return $this->belongsToMany(Product::class, 'order_product', '');
        return $this->belongsToMany(Product::class, 'order_product', '')->withPivot('quantity', 'value')->withTimestamps();
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
