<?php

namespace App\Http\Requests;

use App\Asset;
use App\Exceptions\UnauthorizedException;
use App\Finance;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAsset extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param Asset $asset
	 * @return bool
	 */
	public function authorize(Asset $asset)
	{
		return $this->user()->can('create', $asset);
	}

	/**
	 * Handle a failed authorization attempt.
	 *
	 * @return void
	 *
	 * @throws UnauthorizedException
	 */
	protected function failedAuthorization()
	{
		throw new UnauthorizedException();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'school_id' => 'required|exists:schools,id',
			'category_id' => 'required|exists:categories,id',
			'type_id' => 'required|exists:types,id',
			'tag' => [
				'required',
				Rule::unique('assets')->where(function ($query) {
					$query->where('school_id', request('school_id'));
				}),
			],
			'name' => 'required',
			'accounting_start' => 'date',
			'accounting_end' => 'date',
			'purchase_date' => 'date',
			'end_of_life' => 'date',
			'purchase_cost' => 'numeric',
			'current_value' => 'numeric',
			'depreciation' => 'numeric',
			'net_book_value' => 'numeric',
		];
	}

	/**
	 * Get custom messages for validator errors.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'school_id.required' => 'Please choose a school',
			'school_id.integer' => 'The school provided is not in the correct format',
			'school_id.exists' => 'The school provided does not exist',
			'category_id.required' => 'Please choose a category',
			'category_id.integer' => 'The category provided is not in the correct format',
			'category_id.exists' => 'The category provided does not exist',
			'type_id.required' => 'Please choose an asset type',
			'type_id.integer' => 'The asset type provided is not in the correct format',
			'type_id.exists' => 'The asset type provided does not exist',
			'tag.required' => 'Please provide an asset tag for this asset',
			'tag.unique' => 'This tag is taken by another asset. Please choose a unique tag',
			'name.required' => 'Please give this asset a name',
			'accounting_start.date' => 'The accounting start date is not in the correct format',
			'accounting_end.date' => 'The accounting end date is not in the correct format',
			'purchase_date.date' => 'The purchase date is not in the correct format',
			'end_of_life.date' => 'The end of life date is not in the correct format',
			'purchase_cost.numeric' => 'The purchase cost must be a number',
			'current_value.numeric' => 'The current value must be a number',
			'depreciation.numeric' => 'The depreciation value must be a number',
			'net_book_value.numeric' => 'The net book value must be a number'
		];
	}

	/**
	 * Persist the requested data.
	 *
	 * @return mixed
	 */
	public function persist()
	{
		$asset = Asset::create([
			'school_id' => $this->school_id,
			'category_id' => $this->category_id,
			'type_id' => $this->type_id,
			'name' => $this->name,
			'tag' => $this->tag,
			'serial_number' => $this->serial_number,
			'make' => $this->make,
			'model' => $this->model,
			'processor' => $this->processor,
			'memory' => $this->memory,
			'storage' => $this->storage,
			'operating_system' => $this->operating_system,
			'warranty' => $this->warranty,
			'notes' => $this->notes,
		]);

		if ($asset->wasRecentlyCreated) {
			Finance::create([
				'asset_id' => $asset->id,
				'accounting_start' => $this->accounting_start,
				'accounting_end' => $this->accounting_end,
				'purchase_date' => $this->purchase_date,
				'end_of_life' => $this->end_of_life,
				'purchase_cost' => $this->purchase_cost,
				'current_value' => $this->current_value,
				'depreciation' => $this->depreciation,
				'net_book_value' => $this->net_book_value,
			]);
		}

		return $asset;
	}
}
