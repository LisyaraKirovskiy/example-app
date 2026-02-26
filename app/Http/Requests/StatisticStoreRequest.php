<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatisticStoreRequest extends FormRequest
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
                'like' => 'sometimes|in:true,false',
                'dislike' => 'sometimes|in:true,false',
            ]
        ;
    }
    public function messages(): array
    {
        return [
            'like.boolean' => 'Отправлен не BOOLEAN',
            'dislike.boolean' => 'Отправлен не BOOLEAN',
        ];
    }
}
