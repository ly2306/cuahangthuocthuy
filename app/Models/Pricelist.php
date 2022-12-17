<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricelist extends Model
{
    use HasFactory;
    protected $table = 'pricelist';

    public function PricelistDetail()
    {
        return $this->hasMany(PricelistDetail::class);
    }

    public function Product()
    {
        return $this->belongsToMany(Product::class, 'pricelistdetail', 'pricelist_id', 'product_id');
    }
}
