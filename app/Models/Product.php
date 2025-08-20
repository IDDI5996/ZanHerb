<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'use',
        'ingredients',
        'price',
        'pack_size',
        'tmda_status',
        'image_path'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Scope for approved products
     */
    public function scopeApproved($query)
    {
        return $query->where('tmda_status', 'approved');
    }

    /**
     * Scope for featured products
     */
    public function scopeFeatured($query)
    {
        return $query->approved()
                    ->orderBy('created_at', 'desc')
                    ->limit(3);
    }

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute()
    {
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }
        
        return asset('storage/'.$this->image_path);
    }

    /**
     * Get the formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return '$'.number_format($this->price, 2);
    }

    /**
     * Relationship with bookings
     */
    public function bookings()
    {
        return number_format($this->price) . ' TZS';
    }
}