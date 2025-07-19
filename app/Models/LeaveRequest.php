<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveRequest extends Model
{
    protected $fillable = [
        'user_id',
        'from_date',
        'to_date',
        'reason',
        'status',
        'admin_comment'
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date'
    ];

    /**
     * Get the user that owns the leave request
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}