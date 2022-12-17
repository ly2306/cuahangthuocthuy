<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';

    public function Catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function PricelistDetails()
    {
        return $this->hasMany(PricelistDetail::class);
    }

    public function Item()
    {
        return $this->hasMany(Item::class);
    }

    public function Pricelist()
    {
        return $this->belongsToMany(Pricelist::class, 'pricelistdetail', 'product_id', 'pricelist_id');
    }

    public function InvoiceDetail()
    {
        return $this->hasManyThrough(InvoiceDetail::class, Item::class);
    }
}
