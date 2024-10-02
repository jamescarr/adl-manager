<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Patient;
use App\Models\AdlType;
use App\Models\User;

class AdlRecord extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'patient_id',
        'adl_type_id',
        'status',
        'notes',
        'recorded_at',
        'duration',
        'assistance_level',
        'mood',
        'pain_level',
        'created_by',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'duration' => 'integer',
        'pain_level' => 'integer',
    ];

    public static function validationRules()
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'adl_type_id' => 'required|exists:adl_types,id',
            'status' => 'required|in:pending,in_progress,completed',
            'notes' => 'nullable|string|max:1000',
            'recorded_at' => 'required|date',
            'duration' => 'nullable|integer|min:0',
            'assistance_level' => 'nullable|in:independent,minimal,moderate,maximal,total',
            'mood' => 'nullable|in:happy,neutral,sad,angry,anxious',
            'pain_level' => 'nullable|integer|min:0|max:10',
            'created_by' => 'required|exists:users,id',
        ];
    }

    public static function attributes()
    {
        return [
            'patient_id' => [
                'label' => 'Patient',
                'type' => 'select',
                'options' => Patient::pluck('name', 'id'),
                'placeholder' => 'Select a patient',
            ],
            'adl_type_id' => [
                'label' => 'ADL Type',
                'type' => 'select',
                'options' => AdlType::pluck('name', 'id'),
                'placeholder' => 'Select an ADL type',
            ],
            'status' => [
                'label' => 'Status',
                'type' => 'select',
                'options' => [
                    'pending' => 'Pending',
                    'in_progress' => 'In Progress',
                    'completed' => 'Completed',
                ],
                'placeholder' => 'Select status',
            ],
            'notes' => [
                'label' => 'Notes',
                'type' => 'textarea',
                'placeholder' => 'Enter any additional notes',
            ],
            'recorded_at' => [
                'label' => 'Recorded At',
                'type' => 'datetime-local',
                'placeholder' => 'Select date and time',
            ],
            'duration' => [
                'label' => 'Duration (minutes)',
                'type' => 'number',
                'placeholder' => 'Enter duration in minutes',
            ],
            'assistance_level' => [
                'label' => 'Assistance Level',
                'type' => 'select',
                'options' => [
                    'independent' => 'Independent',
                    'minimal' => 'Minimal Assistance',
                    'moderate' => 'Moderate Assistance',
                    'maximal' => 'Maximal Assistance',
                    'total' => 'Total Assistance',
                ],
                'placeholder' => 'Select assistance level',
            ],
            'mood' => [
                'label' => 'Mood',
                'type' => 'select',
                'options' => [
                    'happy' => 'Happy',
                    'neutral' => 'Neutral',
                    'sad' => 'Sad',
                    'angry' => 'Angry',
                    'anxious' => 'Anxious',
                ],
                'placeholder' => 'Select mood',
            ],
            'pain_level' => [
                'label' => 'Pain Level',
                'type' => 'range',
                'min' => 0,
                'max' => 10,
                'step' => 1,
            ],
        ];
    }

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function adlType()
    {
        return $this->belongsTo(AdlType::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeRecent(Builder $query)
    {
        return $query->where('recorded_at', '>=', now()->subDays(7));
    }

    // Accessors and Mutators
    public function getDurationInMinutesAttribute()
    {
        return $this->duration ? round($this->duration / 60) : null;
    }

    public function setDurationInMinutesAttribute($value)
    {
        $this->attributes['duration'] = $value * 60;
    }

    // Helper methods
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->save();
    }

    // Boot method
    protected static function booted()
    {
        static::creating(function ($adlRecord) {
            if (!$adlRecord->recorded_at) {
                $adlRecord->recorded_at = now();
            }
            if (!$adlRecord->created_by) {
                $adlRecord->created_by = auth()->id();
            }
        });
    }
}
