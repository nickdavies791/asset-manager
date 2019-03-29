<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Finance extends Model
{
	use SoftDeletes;

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 * The attributes that are dates.
	 *
	 * @var array
	 */
	protected $dates = [
		'accounting_start', 'accounting_end',
		'purchase_date', 'end_of_life', 'transferred_at'
	];

	/*
	 * Returns the asset associated with a finance record
	 */
	public function asset()
	{
		return $this->belongsTo(Asset::class);
	}

	/**
	 * Gets the purchase cost in pounds.
	 *
	 * @param $value
	 * @return float|int
	 */
	public function getPurchaseCostAttribute($value)
	{
		return $value / 100;
	}

	/**
	 * Sets the purchase cost in pence.
	 *
	 * @param $value
	 */
	public function setPurchaseCostAttribute($value)
	{
		$this->attributes['purchase_cost'] = $value * 100;
	}

	/**
	 * Gets the current value in pounds.
	 *
	 * @param $value
	 * @return float|int
	 */
	public function getCurrentValueAttribute($value)
	{
		return $value / 100;
	}

	/**
	 * Sets the current value in pence.
	 *
	 * @param $value
	 */
	public function setCurrentValueAttribute($value)
	{
		$this->attributes['current_value'] = $value * 100;
	}

	/**
	 * Gets the depreciation value in pounds.
	 *
	 * @param $value
	 * @return float|int
	 */
	public function getDepreciationAttribute($value)
	{
		return $value / 100;
	}

	/**
	 * Sets the depreciation value in pence.
	 *
	 * @param $value
	 */
	public function setDepreciationAttribute($value)
	{
		$this->attributes['depreciation'] = $value * 100;
	}

	/**
	 * Gets the NBV in pounds.
	 *
	 * @param $value
	 * @return float|int
	 */
	public function getNetBookValueAttribute($value)
	{
		return $value / 100;
	}

	/**
	 * Sets the NBV in pence.
	 *
	 * @param $value
	 */
	public function setNetBookValueAttribute($value)
	{
		$this->attributes['net_book_value'] = $value * 100;
	}
}
