<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
     use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'is_active'
    ];

    /**
     * Scope a query to only include active notifications.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
