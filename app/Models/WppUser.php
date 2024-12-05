<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WppUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'whatsapp_id',
        'name',
    ];

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }
}