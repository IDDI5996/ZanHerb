<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorialProgress extends Model
{
    protected $table = 'tutorial_progress';

    protected $fillable = [
        'tutorial_id',
        'owner_key',          // "user:ID" or "session:SESSION_ID"
        'seconds_watched',
        'progress_percent',
        'duration_seconds',
        'last_second',
    ];

    public function tutorial()
    {
        return $this->belongsTo(Tutorial::class);
    }
}
