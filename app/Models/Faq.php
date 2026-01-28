<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Faq extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['question', 'answer'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['question', 'answer'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn (string $eventName) => "This faq has been {$eventName}");
    }

    public function scopeSearch(Builder $query, $val)
    {
        if ($val === '' || $val === null) {
            return $query;
        }
        return $query->where('question', 'like', '%' . $val . '%')
            ->orWhere('answer', 'like', '%' . $val . '%');
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->inUserTimezone(),
        );
    }
}
