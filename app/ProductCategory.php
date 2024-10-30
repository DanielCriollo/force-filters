<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ProductCategory extends Model
{
    protected $table = 'product_categories';

    protected $fillable = [
        'product_type_id',
        'name',
        'description',
    ];

    public function productType()    {
        return $this->belongsTo(ProductType::class);
    }
}
