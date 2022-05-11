<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
     * Валидация формы авторизации
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => "required|email",
            'password' => "required|min:8"
        ];
    }

    /**
     * Текст ошибки валидации
     * 
     */

    public function messages(){
        return [
            'email.required' => 'Не введен e-mail адрес',
            'password.required' => 'Не введен пароль',
            'email.email' => "Поле e-mail не является адресом электронной почты",
            'password.min' => "Минимальная длина пароля 8 символов"
        ];
    }
}
