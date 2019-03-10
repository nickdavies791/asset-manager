<?php

namespace App\Http\Requests;

use App\Asset;
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
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'school' => 'required|integer|exists:schools,id',
			'tag' => [
				'required',
				Rule::unique('assets')->where(function ($query) {
					$query->where('school_id', request('school'));
				}),
			],
			'name' => 'required|string',
			'serial_number' => 'string',
			'make' => 'string',
			'model' => 'string',
			'processor' => 'string',
			'memory' => 'string',
			'storage' => 'string',
			'operating_system' => 'string',
			'warranty' => 'string',
			'notes' => 'string',
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
			'school.required' => 'Please choose a school',
			'school.integer' => 'The school provided is not in the correct format',
			'school.exists' => 'The school provided does not exist',
			'tag.required' => 'Please provide an asset tag for this asset',
			'tag.unique' => 'This tag is taken by another asset. Please choose a unique tag',
			'serial_number.string' => 'The serial number provided is not in the correct format',
			'make.string' => 'The make provided is not in the correct format',
			'model.string' => 'The model provided is not in the correct format',
			'processor.string' => 'The processor provided is not in the correct format',
			'memory.string' => 'The memory provided is not in the correct format',
			'storage.string' => 'The storage provided is not in the correct format',
			'operating_system.string' => 'The operating system provided is not in the correct format',
			'warranty.string' => 'The warranty provided is not in the correct format',
			'notes.string' => 'Notes provided is not in the correct format',
		];
	}
}
