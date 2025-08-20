<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'image_path',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];

    /**
     * Scope for active promotions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('start_date', '<=', Carbon::today())
                    ->where('end_date', '>=', Carbon::today());
    }

    /**
     * Check if promotion is currently active
     */
    public function isActive(): bool
    {
        return $this->is_active && 
               Carbon::today()->between($this->start_date, $this->end_date);
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
     * Determine if the promotion contains a video
     */
    public function isVideo(): bool
    {
        $videoExtensions = ['mp4', 'mov', 'avi', 'webm'];
        $extension = pathinfo($this->image_path, PATHINFO_EXTENSION);
        
        return in_array(strtolower($extension), $videoExtensions);
    }
}