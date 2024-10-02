<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use OwenIt\Auditing\Contracts\Auditable;

class AdlType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'description',
        'category',
        'estimated_duration',
        'is_active',
    ];

    protected $casts = [
        'estimated_duration' => 'integer',
        'is_active' => 'boolean',
    ];

    public function adlRecords()
    {
        return $this->hasMany(AdlRecord::class);
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory(Builder $query, $category)
    {
        return $query->where('category', $category);
    }

    public function getEstimatedDurationInMinutesAttribute()
    {
        return $this->estimated_duration ? round($this->estimated_duration / 60) : null;
    }

    public function setEstimatedDurationInMinutesAttribute($value)
    {
        $this->attributes['estimated_duration'] = $value * 60;
    }

    public static function getCategories()
    {
        return self::distinct('category')->pluck('category');
    }

    public function getUsageCountAttribute()
    {
        return $this->adlRecords()->count();
    }

    public function getAverageCompletionTimeAttribute()
    {
        return $this->adlRecords()->avg('duration');
    }

    public function isFrequentlyUsed()
    {
        $threshold = 10; // Define what "frequently used" means
        return $this->getUsageCountAttribute() > $threshold;
    }
}
