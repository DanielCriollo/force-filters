<?php

namespace App;

use App\Customer;
use Illuminate\Support\Str;
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

    protected static function booted()
    {
        static::creating(function ($salesOrder) {
            $salesOrder->uuid = (string) Str::uuid();
        });
    }
}
