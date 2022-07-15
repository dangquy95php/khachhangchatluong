<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthenticatableModel;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Laravel\Sanctum\HasApiTokens;
use Stephenjude\DefaultModelSorting\Traits\DefaultOrderBy;
use Hash;
use Carbon\Carbon;

class User extends AuthenticatableModel implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, HasFactory, Notifiable, DefaultOrderBy;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected static $orderByColumn = 'updated_at';

    protected static $orderByColumnDirection = 'desc';

    const HAVENT_CALLED_YET = 0;
    const CALLED = 1;
    const AREA_HAVENT_CALLED_YET = null;
    const APPOINTMENT = 0;

    protected $table = 'users';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'username',
        'role',
        'password',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'id', 'role', 'status', 'name', 'id_user'
    ];

    public function username()
    {
        return 'username';
    }

    const AREA_ACTIVE = 1;

    const NOT_APPROVED_YET = 0;
    const ACTIVE = 1;
    const INACTIVE = 2;

    const STATUS = [
        self::NOT_APPROVED_YET,
        self::ACTIVE,
        self::INACTIVE
    ];

    const USER_ROLE = 1;
    const ADMIN_ROLE = 2;

    const ROLES_ALL = [
        self::USER_ROLE,
        self::ADMIN_ROLE
    ];

    public static function getStatus()
    {
        return self::STATUS;
    }

    public static function getRole()
    {
        return self::ROLES_ALL;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function scopeUser($query)
    {
        return $query->where('role', self::USER_ROLE);
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'areas_customers', 'user_id', 'area_id', 'id')
                    ->where('status', self::AREA_ACTIVE)
                    ->groupBy('pivot_area_id');
    }

    public function areas_users()
    {
        return $this->hasMany(AreaCustomer::class, 'user_id', 'id')->whereNotNull('user_id');
    }
}