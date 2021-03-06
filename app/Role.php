<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Disable all timestamp fields.
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Returns the Users associated with a Role
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
