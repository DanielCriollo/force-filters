<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class SalesOrderItem extends Model
{
    // If your table has a different name, specify it
    protected $table = 'sales_order_items'; // Change if necessary

    // Define the relationship to the Product model
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Assuming 'product_id' is the foreign key in SalesOrderItem
    }

    // Optionally, you might want to specify fillable properties
    protected $fillable = [
        'sales_order_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    // You can also define additional methods or accessors if needed
}