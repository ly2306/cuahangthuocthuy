<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $table = 'invoicedetail';

    public function Invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function Item()
    {
        return $this->belongsTo(Item::class);
    }
}
