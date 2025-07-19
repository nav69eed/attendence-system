<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    protected $fillable = [
        'grade',
        'min_days',
        'max_days'
    ];

    /**
     * Get grade based on attendance days
     *
     * @param int $days
     * @return string|null
     */
    public static function getGradeForDays(int $days): ?string
    {
        $grade = self::where('min_days', '<=', $days)
            ->where('max_days', '>=', $days)
            ->first();

        return $grade ? $grade->grade : null;
    }
}