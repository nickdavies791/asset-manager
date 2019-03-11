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
		'school_id', 'name', 'tag', 'serial_number', 'make', 'model', 'processor', 'memory', 'storage', 'operating_system', 'warranty', 'notes'
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

	/*
	 * Returns the category associated with an asset
	 */
	public function category()
	{
		return $this->belongsTo(Category::class);
	}
}
