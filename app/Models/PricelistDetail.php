<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricelistDetail extends Model
{
    use HasFactory;
    protected $table = 'pricelistdetail';

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }

    public function Pricelist()
    {
        return $this->belongsTo(Pricelist::class);
    }
}
