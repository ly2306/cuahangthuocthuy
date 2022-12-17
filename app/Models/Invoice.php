<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';

    public function getTotalPayment()
    {
        $total = 0;
        foreach($this->InvoiceDetail as $detail)
        {
            $total += $detail->invoice_price;
        }
        return $total;
    }

    public function PricelistDetail()
    {
        return $this->belongsToMany(PricelistDetail::class, 'invoice_pricelist', 'invoice_id', 'pricelistdetail_id');
    }

    public function Customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function InvoiceDetail()
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    public function Item()
    {
        return $this->belongsToMany(Item::class, 'invoicedetail', 'invoice_id', 'item_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
