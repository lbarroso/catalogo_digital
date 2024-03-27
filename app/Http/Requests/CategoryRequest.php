<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoryRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' =>  Str::slug($this->name),
        ]);
    }
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [];

        switch ($this->method()) {
            case 'POST':
                $rules = [
                    'name' => 'required| min:8| max:255',
                    'slug' => 'unique:categories,slug'
                ];
            break;
            
            case 'PUT':
                $rules = [
                    'name' => 'required| min:8| max:255',
                    'slug' => Rule::unique('categories')->ignore($this->id),
                ];
            break;
        }

        return $rules;
    }
}
