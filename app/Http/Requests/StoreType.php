<?php

namespace App\Http\Requests;

use App\Exceptions\UnauthorizedException;
use App\Type;
use Illuminate\Foundation\Http\FormRequest;

class StoreType extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param Type $type
	 * @return bool
	 */
    public function authorize(Type $type)
    {
        if ($this->user()->can('create', $type)) {
        	return true;
		}
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
            'name' => 'required|string'
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
			'name.required' => 'Please enter a name for the asset type',
			'name.string' => 'The name field must be a string'
		];
	}
}
