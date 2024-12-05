<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'step_id',
        'option_text',
        'action_type',
        'action_target',
    ];

    public function step()
    {
        return $this->belongsTo(Step::class);
    }
}