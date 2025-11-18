<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

/**
 * @property-read User $patient
 */

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'name',
        'relation',
        'phone',
        'screening_status',
        'notes',
        'last_screening_answers',
        'last_screened_at',
    ];

    protected $casts = [
        'last_screening_answers' => 'array',
        'last_screened_at' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
