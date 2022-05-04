<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the book is authorized to make this request.
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
            'title' => 'required|unique:books',
            'description' => 'required',
            'poster' => 'sometimes|nullable|image',
            'pdf_url' => 'required',
            'type' => 'required',
            'release_date' => 'required',
            'category_id' => 'required',
            'author_id' => 'required',
            'page_count' => 'required'
            
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $book = $this->route()->parameter('book');

            $rules['title'] = 'required|unique:books,id,' . $book->id;

        }//end of if

        return $rules;

    }//end of rules


}//end of request
