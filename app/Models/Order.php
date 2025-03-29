<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'product_id', 'quantity', 'total_price', 'order_date'];

    // العلاقة مع العميل
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // العلاقة مع المنتج
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
