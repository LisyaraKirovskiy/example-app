<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'name' => 'required|min:3|max:50',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId)
            ],
            'password' => 'nullable|min:5|max:20|confirmed',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'name.min' => 'Имя должно содержать не менее 3 символов',
            'name.max' => 'Имя не должно превышать 50 символов',
            'name.required' => 'Поле "Имя" обязательно',
            'email.required' => 'Поле "E-mail" обязательно',
            'email.unique' => 'Такой email уже есть в базе',
            'email.email' => 'Неверно введен email',
            'password.confirmed' => 'Пароли не совпадают',
            'password.min' => 'Пароль должен содержать не менее 5 символов',
            'password.max' => 'Пароль не должен превышать 20 символов',
            'avatar.image' => 'Файл должен быть изображением',
            'avatar.mimes' => 'Допустимые форматы: jpeg, png, gif',
            'avatar.max' => 'Максимальный размер файла 2MB',
        ];
    }
}
