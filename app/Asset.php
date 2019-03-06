<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'tag', 'name'
	];

	/**
	 * Disable all timestamp fields.
	 * @var boolean
	 */
	public $timestamps = false;
}