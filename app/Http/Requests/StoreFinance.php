<?php

namespace App\Http\Requests;

use App\Asset;
use App\Exceptions\UnauthorizedException;
use App\Finance;
use Illuminate\Foundation\Http\FormRequest;

class StoreFinance extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
    public function authorize()
    {
        return $this->user()->can('update', $this->asset);
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
			'asset_id' => 'required|exists:assets,id',
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
			'asset_id.required' => 'An asset was not provided',
			'asset_id.exists' => 'The asset provided does not exist',
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
	 * @param Asset $asset
	 * @return mixed
	 */
    public function persist(Asset $asset)
	{
		$finance = Finance::create([
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

		return $finance;
	}
}
