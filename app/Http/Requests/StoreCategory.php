<?php

namespace App\Http\Requests;

use App\Category;
use App\Exceptions\UnauthorizedException;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategory extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @param Category $category
	 * @return bool
	 */
    public function authorize(Category $category)
    {
    	if ($this->user()->can('create', $category)) {
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
			'name.required' => 'Please enter a name for the category',
			'name.string' => 'The name field must be a string'
		];
	}
}
