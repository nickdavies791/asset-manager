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
        'name', 'email', 'password',
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

    /**
     * Returns the Role associated with a User
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /*
     * Returns the schools associated with a user
     */
    public function schools()
    {
        return $this->belongsToMany(School::class);
    }

    /**
     * Returns whether the user has the 'Administrator' role
     *
     * @return bool
     */
    public function isAdministrator()
    {
        return $this->role()->where('name', 'Administrator')->exists();
    }

    /**
     * Returns whether the user has the 'Contributor' role
     *
     * @return bool
     */
    public function isContributor()
    {
        return $this->role()->where('name', 'Contributor')->exists();
    }

    /**
     * Returns whether the user has the 'Reader' role
     *
     * @return bool
     */
    public function isReadOnly()
    {
        return $this->role()->where('name', 'Read Only')->exists();
    }
}
