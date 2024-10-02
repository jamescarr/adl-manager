<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use OwenIt\Auditing\Contracts\Auditable;
use Carbon\Carbon;

class Patient extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'date_of_birth',
        'gender',
        'contact_number',
        'email',
        'address',
        'emergency_contact_name',
        'emergency_contact_number',
        'medical_history',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function adlRecords()
    {
        return $this->hasMany(AdlRecord::class);
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth->age;
    }

    public function scopeActive(Builder $query)
    {
        return $query->whereHas('adlRecords', function ($query) {
            $query->where('recorded_at', '>=', now()->subDays(30));
        });
    }

    public function scopeByAgeRange(Builder $query, $minAge, $maxAge)
    {
        $minDate = Carbon::now()->subYears($maxAge);
        $maxDate = Carbon::now()->subYears($minAge);

        return $query->whereBetween('date_of_birth', [$minDate, $maxDate]);
    }

    public function getFullNameAttribute()
    {
        return "{$this->name}";
    }

    public function getLatestAdlRecordAttribute()
    {
        return $this->adlRecords()->latest('recorded_at')->first();
    }

    public function getAdlRecordCountAttribute()
    {
        return $this->adlRecords()->count();
    }

    public function hasRecentAdlRecord()
    {
        return $this->adlRecords()->where('recorded_at', '>=', now()->subDays(7))->exists();
    }
}
