<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory; // NEW: Added Factory support

    protected $fillable = [
        'user_id', 
        'name', 
        'email', 
        'phone', 
        'condition', 
        'preferred_date', 
        'preferred_time', 
        'product_id',
        'service_id',
        'status',
        'notes', // NEW: Added optional notes field
        'is_archived'
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => 'string', // NEW: Explicit status casting
        'is_archived' => 'boolean'
    ];

    // NEW: Status constants for consistency
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_COMPLETED = 'completed';

    // NEW: Status options for forms/validation
    public static function statusOptions()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_COMPLETED => 'Completed'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault([
            'name' => 'General Consultation', // NEW: Default if product deleted
            'price' => 0
        ]);
    }

    //Scope for pending bookings
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    //Scope for confirmed bookings
    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    //Check if booking is confirmed
    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    //Check if booking is pending
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    // Accessor for formatted preferred_date (updated format)
    public function getFormattedPreferredDateAttribute()
    {
        return $this->preferred_date->format('l, F j, Y'); // NEW: More detailed format
    }

    // Accessor for preferred_time (updated)
    public function getFormattedPreferredTimeAttribute()
    {
        return Carbon::parse($this->preferred_time)->format('g:i A'); // NEW: Using Carbon
    }

    // NEW: Combined date/time accessor
    public function getFormattedDateTimeAttribute()
    {
        return $this->formatted_preferred_date.' at '.$this->formatted_preferred_time;
    }
    
    public function getFormattedDateAttribute()
    {
        return $this->preferred_date->format('D, M j, Y');
    }

    public function getFormattedTimeAttribute()
    {
        return date('g:i A', strtotime($this->preferred_time));
    }
    
    //Service relationships
    public function service()
    {
    return $this->belongsTo(Service::class);
    }
    //Get status badge HTML
    public function getStatusBadgeAttribute()
    {
        $statuses = [
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_CONFIRMED => 'bg-green-100 text-green-800',
            self::STATUS_CANCELLED => 'bg-red-100 text-red-800',
            self::STATUS_COMPLETED => 'bg-blue-100 text-blue-800'
        ];

        return '<span class="px-2 py-1 text-xs rounded-full '.$statuses[$this->status].'">'.
               ucfirst($this->status).
               '</span>';
    }
}