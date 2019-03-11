<?php

namespace App\Http\Requests;

use App\Category;
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
        return $this->user()->can('create', $category);
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
}
