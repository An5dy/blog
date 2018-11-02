<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
        return [
            'title' => 'bail|required|string|max:60',
            // 'cover_img' => 'bail|string|max:255',
            'category_id' => 'bail|required|integer|exists:categories,id',
            'markdown' => 'bail|required|string',
            'tags.*' => 'bail|string|max:60',
        ];
    }
}
