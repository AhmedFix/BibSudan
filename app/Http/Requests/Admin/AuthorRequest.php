<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
{
    /**
     * Determine if the author is authorized to make this request.
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
            'name' => 'required|unique:authors',
            'image' => 'sometimes|nullable',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $author = $this->route()->parameter('author');

            $rules['name'] = 'required|unique:authors,id,' . $author->id;

        }//end of if

        return $rules;

    }//end of rules


}//end of request
