<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'body' => 'required|string',
            'cover_image' => 'sometimes|image',
            'pinned' => 'required|boolean',
            'tags' => 'array', // Assuming you will pass tags as an array
            'tags.*' => 'exists:tags,id', // Assuming the tags exist in a 'tags' table with 'id' column
        ];
    }
}
