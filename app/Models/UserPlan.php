<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserPlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'activated_at' => 'datetime',
        'next_growth' => 'datetime',
        'expire_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function rois(): HasMany
    {
        return $this->hasMany(Roi::class);
    }

    public function scopeStatus(Builder $query, string $status): void
    {
        if ($status !== 'All') {
            $query->where('status', $status);
        }
    }

    // scope search
    public function scopeCustomer(Builder $query, string $value): void
    {
        if ($value !== 'All') {
            $query->WhereHas('user', function ($query) use ($value) {
                $query->where('name', $value);
            });
        }
    }

    // scope date
    public function scopeBetweenDate(Builder $query, string $fromDate, string $toDate): void
    {
        if ($fromDate !== '' && $toDate !== '') {
            $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }
    }

    // mutate created_at and add one hour
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->inUserTimezone(),
        );
    }

    protected function expireDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->inUserTimezone(),
        );
    }

    protected function nextGrowth(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->inUserTimezone(),
        );
    }
}
