<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $table = 'attendance_records';
    
    protected $fillable = [
        'user_id',
        'date',
        'check_in_time',
        'status',
        'is_late'
    ];

    protected $casts = [
        'date' => 'date',
        'check_in_time' => 'datetime',
        'is_late' => 'boolean'
    ];

    /**
     * Get the user that owns the attendance record
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to filter attendance records by date range
     */
    public function scopeDateRange($query, $fromDate, $toDate)
    {
        if ($fromDate) {
            $query->where('date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->where('date', '<=', $toDate);
        }

        return $query;
    }

    /**
     * Scope a query to filter attendance records by status
     */
    public function scopeStatus($query, $status)
    {
        if ($status) {
            if ($status === 'late') {
                return $query->where('is_late', true);
            }
            return $query->where('status', $status);
        }

        return $query;
    }

    /**
     * Check if a user has already marked attendance for today
     */
    public static function hasMarkedToday($userId)
    {
        return static::where('user_id', $userId)
            ->whereDate('date', today())
            ->exists();
    }

    /**
     * Get the attendance status for display
     */
    public function getDisplayStatus(): string
    {
        if ($this->is_late) {
            return 'late';
        }

        return $this->status;
    }
}