<?php

namespace App;

use App\Notifications\VerifyUserNotification;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use \DateTimeInterface;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, HasApiTokens;

    public $table = 'users';

    protected $hidden = [
        'remember_token',
        'password',
        'idno',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'firstname',
        'lastname',
        'middlename',
        'email',
        'address',
        'nationalid',
        'number',
        'email_verified_at',
        'password',
        'status',
        'idno',
        'avatar',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'dateofbirth',
        'joinedsacco',
        'firebaseid',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getIsAdminAttribute()
    {
        return $this->roles->contains(1);
    }

    public function getIsMemberAttribute()
    {
        return $this->roles->contains(2);
    }

    public function getIsAccountantAttribute()
    {
        return $this->roles->contains(3);
    }

    public function getIsCreditCommitteeAttribute()
    {
        return $this->roles->contains(4);
    }

    public function getIsExecutiveAttribute()
    {
        return $this->roles->contains(5);
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {
            $registrationRole = config('panel.registration_default_role');

            if (!$user->roles()->get()->contains($registrationRole)) {
                $user->roles()->attach($registrationRole);
            }
            
        });

    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function userAccount()
    {
        return $this->hasOne(UsersAccount::class, 'user_id');

    }

    public function loan()
    {
        return $this->hasMany(LoanApplication::class, 'created_by_id');

    }

    public function monthlySavings()
    {
        return $this->hasOne(MonthlySavings::class, 'user_id');
    }

    public function twoStep()
    {
        return $this->hasOne(TwoStepAuthTable::class, 'userId');
    }

    public function nextKin()
    {
        return $this->hasMany(NextKin::class, 'user_id');
    }
}
