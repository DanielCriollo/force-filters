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

    public static function getNextInvoiceNumber()
    {
        $lastOrder = self::whereNotNull('invoice_number')->orderByDesc('id')->first();

        if ($lastOrder) {

            $lastNumber = (int) str_replace('FV-', '', $lastOrder->invoice_number);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return 'FV-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
