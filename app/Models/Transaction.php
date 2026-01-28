<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeStatus(Builder $query, string $status): void
    {
        if ($status !== 'all') {
            $query->where('status', $status);
        }
    }

    // scope search
    public function scopeSearch(Builder $query, string $search): void
    {
        if ($search !== '') {
            $query->orWhereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            });
        }
    }

    // scope date
    public function scopeDate(Builder $query, string $fromDate, string $toDate): void
    {
        if ($fromDate !== '' && $toDate !== '') {
            //add one day to toDate
            $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->inUserTimezone(),
        );
    }
}
