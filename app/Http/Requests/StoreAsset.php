<?php

namespace App\Http\Requests;

use App\Asset;
use App\Exceptions\UnauthorizedException;
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
		];
	}
}
