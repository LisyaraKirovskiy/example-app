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
        $userId = $this->route('user'); // получаем ID из маршрута

        return [
            'name' => 'required|min:3|max:50',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId) // игнорируем текущего пользователя
            ],
            'password' => 'nullable|min:5|max:20|confirmed', // nullable для update
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
        ];
    }
}
