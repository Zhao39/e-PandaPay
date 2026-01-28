<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SymbolMap extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'from_symbol', 'to_symbol',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['from_symbol', 'to_symbol'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn (string $eventName) => "This symbol has been {$eventName}");
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->inUserTimezone(),
        );
    }
}
