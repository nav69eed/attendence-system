<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'submission_date',
        'file_path',
    ];

    /**
     * Get the task that owns the submission.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user who made the submission.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
