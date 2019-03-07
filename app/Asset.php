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
		'school_id', 'tag', 'name'
	];

	/**
	 * Disable all timestamp fields.
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Returns the school associated with an asset
	 */
	public function school()
	{
		return $this->belongsTo(School::class);
	}
}
