<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return
            [
                'name' => 'required|min:5|max:50',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:5|max:20',
                'avatar' => 'nullable|file|image|mimes:jpeg,png,gif|max:2048'
            ]
        ;
    }
    public function messages(): array
    {
        return [
            'name.min' => 'Имя должно содержать не менее 5 символов',
            'name.max' => 'Имя не должно превышать 50 символов',
            'name.required' => 'Поле "Имя" - обязательное',
            'email.required' => 'Поле "E-mail" - обязательное',
            'email.unique' => 'Такой email уже есть в базе',
            'email.email' => 'Неверно введен email',
            'password.required' => 'Поле "Пароль" - обязательное',
            'password.confirmed' => 'Пароли не совпадают',
            'password.min' => 'Пароль должен содержать не менее 5 символов',
            'password.max' => 'Пароль не должен превышать 20 символов',
            'avatar.image' => 'Файл должен быть изображением',
            'avatar.mimes' => 'Допустимые форматы: jpeg, png, gif',
            'avatar.max' => 'Максимальный размер файла 2MB',
        ];
    }
}
