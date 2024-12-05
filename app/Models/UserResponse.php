<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'step_id',
        'response_text',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function step()
    {
        return $this->belongsTo(Step::class);
    }
}