<?php

namespace App;

use App\SalesOrder;
use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    protected $fillable = [
        'name',
        'identification',
        'address',
        'phone',
        'email',
    ];

    public function sales()
    {
        return $this->hasMany(SalesOrder::class);
    }
}
