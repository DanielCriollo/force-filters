<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    protected $fillable = [
        'step_name',
        'step_type',
        'prompt',
        'next_step',
    ];

    public function nextStep()
    {
        return $this->belongsTo(Step::class, 'next_step');
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}