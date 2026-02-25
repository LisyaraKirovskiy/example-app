<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoStoreRequest extends FormRequest
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
        return
            [
                'name' => 'required|min:5|max:200',
                'description' => 'nullable',
                'path' => 'required|max:500',
            ]
        ;
    }
    public function messages(): array
    {
        return [
            'name.min' => 'Название видео должно содержать не менее 5 символов',
            'name.max' => 'Название видео не должно превышать 200 символов',
            'path.max' => 'Путь должен содержать меньше 500 символов',
            'path.required' => 'Поле путь - обязательное',
        ];
    }
}
