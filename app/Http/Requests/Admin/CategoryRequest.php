<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the category is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|unique:categories',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $category = $this->route()->parameter('category');

            $rules['name'] = 'required|unique:categories,id,' . $category->id;

        }//end of if

        return $rules;

    }//end of rules


}//end of request
