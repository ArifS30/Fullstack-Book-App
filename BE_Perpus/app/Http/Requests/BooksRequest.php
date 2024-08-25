<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BooksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isUpdate = $this->route('id') !== null;

        if ($isUpdate) {
            return [
                'title' => 'required|max:255',
                'summary' => 'required',
                'image' => 'nullable',
                'stock' => 'required|integer',
                'category_id' => 'required|exists:categories,id',
            ];
        } else {
            return [
                'title' => 'required|max:255',
                'summary' => 'required',
                'image' => 'required|mimes:jpg,bmp,png',
                'stock' => 'required|integer',
                'category_id' => 'required|exists:categories,id',
            ];
        }
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.max' => 'Title Max is 255 Characters',
            'summary.required' => 'Summary is required',
            'image.mimes' => 'Image must be jpg, bmp, or png',
            'image.nullable' => 'Image is optional when editing',
            'stock.required' => 'Stock is required',
            'stock.integer' => 'Stock must be an integer',
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Category Not Found',
        ];
    }
}
