<?php

namespace App;

use App\Customer;
use Illuminate\Database\Eloquent\Model;


class SalesOrder extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SalesOrderItem::class, 'sales_order_id');
    }
}
