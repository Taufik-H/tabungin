<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    protected $fillable = [
        'slug', 'messages',
    ];

    protected $casts = [
        'messages' => 'array',
    ];

    public function scopeExpired($query)
    {
        return $query->where('created_at', '<', now()->subDay());
    }
}
