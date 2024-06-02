<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoodsRequest extends FormRequest
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
            'title' => 'required|max:30',
            'category_id' => 'required',
            'price' => 'required|min:0',
            'stock' => 'required|min:0',
            'cover' => 'required',
            'description' => 'required',
            'details' => 'required'
        ];
    }
}
