<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Roi extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_plan_id',
        'amount',
    ];

    public function userPlan(): BelongsTo
    {
        return $this->belongsTo(UserPlan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // scope date
    public function scopeBetweenDate(Builder $query, string $fromDate, string $toDate): void
    {
        if ($fromDate !== '' && $toDate !== '') {
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
