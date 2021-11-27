<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    const ADMIN_TYPE = 'superAdmin';
    const NADMIN_TYPE = 'superAdmin';
    const USER_TYPE = 'user';

public function isAdmin() {
     return $this->type === self::ADMIN_TYPE || $this->type === self::NADMIN_TYPE;
 }

public function isNormalUser() {
     return $this->type === self::USER_TYPE;
} 
}
