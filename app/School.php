<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id', 'name'
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
}
