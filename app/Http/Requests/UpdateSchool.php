<?php

namespace App\Http\Requests;

use App\Exceptions\UnauthorizedException;
use App\School;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSchool extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param School $school
	 * @return bool
	 */
    public function authorize(School $school)
    {
        if ($this->user()->can('create', $school)) {
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
			'name.required' => 'Please enter a name for the school',
			'name.string' => 'The name field must be a string'
		];
	}
}
