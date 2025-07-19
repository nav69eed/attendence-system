<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $casts = [
        'attachments' => 'array',
        'due_date' => 'datetime',
    ];

    protected $guarded = [];
    // protected $fillable = [
    //     'assigned_by',
    //     'assigned_to',
    //     'grade_level_id',
    //     'title',
    //     'description',
    //     'response',
    //     'status',
    //     'feedback',
    //     'attachments'
    // ];

    /**
     * Get the user who assigned the task
     */
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /**
     * Get the user to whom the task is assigned
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the grade level this task is assigned to
     */
    public function gradeLevel(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class);
    }

    /**
     * Get the submissions for the task.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}
