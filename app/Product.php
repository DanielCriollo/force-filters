<?php

namespace App;

use App\Brand;
use App\SalesOrder;
use App\SalesOrderItem;
use App\ProductCategory;
use App\Models\ProductPriceHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    
    protected $table = 'products';

    
    protected $fillable = [
        'name',
        'description',
        'sku',
        'product_type_id',
        'product_category_id',
        'brand_id',
        'cost_price',
        'sale_price',
        'stock_quantity',
        'min_stock_quantity',
        'reorder_quantity',
        'main_photo'
    ];

    
    protected $casts = [
        'cost_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'min_stock_quantity' => 'integer',
        'reorder_quantity' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function salesOrdersItems()
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    public function priceHistories()
    {
        return $this->hasMany(ProductPriceHistory::class);
    }
}