<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
	use SoftDeletes;

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
	 * Returns the users associated with a school
	 */
	public function users()
	{
		return $this->belongsToMany(User::class);
	}

	/**
	 * Returns the assets associated with a school
	 */
	public function assets()
	{
		return $this->hasMany(Asset::class);
	}
}
