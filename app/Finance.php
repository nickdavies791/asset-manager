<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'asset_id', 'accounting_start', 'accounting_end', 'purchase_date', 'end_of_life', 'purchase_cost', 'current_value', 'depreciation', 'net_book_value', 'transferred_at'
	];

	/**
	 * Disable all timestamp fields.
	 * @var boolean
	 */
	public $timestamps = false;

	/*
	 * Returns the asset associated with a finance record
	 */
	public function asset()
	{
		return $this->belongsTo(Asset::class);
	}
}
