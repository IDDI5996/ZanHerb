<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'long_description',
        'duration',
        'price',
        'is_active',
        'category',
        'icon',
        'secondary_icon',
        'featured',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'featured' => 'boolean'
    ];
    
    // Scope for active services
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for featured services
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    // Scope for services by category
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Get all available categories
    public static function getCategories()
    {
        return [
            'Clinical & Therapeutic Care',
            'Health Education & Training',
            'Research & Innovation',
            'Community Empowerment & Partnerships',
            'ZanHerb Remedies'
        ];
    }
}
