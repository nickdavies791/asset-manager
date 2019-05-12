<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Disable all timestamp fields.
     * @var boolean
     */
    public $timestamps = false;

    /*
     * Returns the assets associated with a category
     */
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    /*
     * Returns the types associated with a category
     */
    public function types()
    {
        return $this->belongsToMany(Type::class);
    }
}
