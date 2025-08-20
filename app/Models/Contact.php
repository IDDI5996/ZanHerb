<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'message',
        'admin_response',
        'responded'
    ];

    /**
     * Scope a query to only include unresponded contacts.
     */
    public function scopeUnresponded($query)
    {
        return $query->where('responded', false);
    }
}
