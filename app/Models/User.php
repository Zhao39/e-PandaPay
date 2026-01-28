<?php

namespace App\Models;

use App\Enums\UserStatus;
use App\Observers\UserObserver;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy(UserObserver::class)]
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'status' => UserStatus::class,
        'trade_mode' => 'boolean',
        'received_signup_bonus' => 'boolean',
        'can_withdraw' => 'boolean',
        'can_deposit' => 'boolean',
        'email_preference' => 'array',
        'enable_2fa' => 'boolean',
        'pass_two_factor' => 'boolean',
        'token_2fa_expiry' => 'datetime',
        'withdrawal_otp_expired_at' => 'datetime',
        'date_of_birth' => 'datetime',
        'date_of_birth' => 'datetime',
    ];

    public function sendEmailVerificationNotification(): void
    {
        $settings = Settings::select('enable_email_verification')->find(1);
        if ($settings->enable_email_verification) {
            $this->notify(new VerifyEmail());
        }
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class);
    }

    // total deposists
    public function totalDeposits(): float
    {
        return $this->deposits()->where('status', 'Processed')->sum('amount');
    }

    // has one crypto account model
    public function account(): HasOne
    {
        return $this->hasOne(CryptoAccount::class);
    }
    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
    }

    // trading plans
    public function tradingAccounts(): HasMany
    {
        return $this->hasMany(TradingAccount::class);
    }

    // total withdrawals
    public function totalWithdrawals(): float
    {
        return $this->withdrawals()->where('status', 'processed')->sum('amount');
    }

    public function investmentPlans(): HasMany
    {
        return $this->hasMany(UserPlan::class);
    }

    public function scopeIsAdmin(Builder $query): void
    {
        $query->where('is_admin', 1);
    }

    public function scopeIsNotAdmin(Builder $query): void
    {
        $query->where('is_admin', 0);
    }

    public static function scopeSearch(Builder $query, string $search = ''): void
    {
        if ($search !== '') {
            $query->whereAny(
                [
                    'name',
                    'username',
                    'email',
                ],
                'LIKE',
                "%{$search}%"
            );
        }
    }

    public function scopeDate(Builder $query, string $fromDate, string $toDate): void
    {
        if ($fromDate !== '' && $toDate !== '') {
            //add one day to toDate
            $toDate = date('Y-m-d', strtotime($toDate . ' +1 day'));

            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }
    }

    public function scopeStatus(Builder $query, string $status): void
    {
        if ($status !== 'All') {
            $query->where('status', $status);
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'username', 'email', 'status', 'account_bal', 'roi', 'bonus', 'updated_at'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This user has been {$eventName}");
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->inUserTimezone(),
        );
    }
}
