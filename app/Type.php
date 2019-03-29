<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
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
	 * Returns the categories associated with a type
	 */
	public function categories()
	{
		return $this->belongsToMany(Category::class);
	}

	/*
	 * Returns the assets associated with a type
	 */
	public function assets()
	{
		return $this->hasMany(Asset::class);
	}
}
