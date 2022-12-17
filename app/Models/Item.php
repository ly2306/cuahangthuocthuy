<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'item';

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }

    public function Invoice()
    {
        return $this->belongsToMany(Invoice::class, 'invoicedetail', 'item_id', 'invoice_id');
    }

    public function InvoiceDetail()
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}
