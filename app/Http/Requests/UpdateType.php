<?php

namespace App\Http\Requests;

use App\Exceptions\UnauthorizedException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateType extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
    	return $this->user()->can('update', $this->type);
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
            'name' => 'required|unique:types'
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
			'name.unique' => 'An asset type with this name already exists'
		];
	}
}

