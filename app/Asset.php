<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
	use SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'school_id', 'category_id', 'type_id', 'name', 'tag', 'serial_number', 'make', 'model', 'processor', 'memory', 'storage', 'operating_system', 'warranty', 'notes'
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

	/*
	 * Returns the type associated with an asset
	 */
	public function type()
	{
		return $this->belongsTo(Type::class);
	}

	/*
	 * Returns the finance records associated with an asset
	 */
	public function finances()
	{
		return $this->hasMany(Finance::class);
	}
}
