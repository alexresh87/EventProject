<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'firstname' => "required|max:50",
            'lastname' => "required|max:50",
            'patronymic' => "required|max:50",
            'city' => "required|max:50",
            'address' => "required|max:150",
            'phone' => "required|max:20",
            'email' => "email|max:50"
        ];
    }

    public function messages(){
        return [
            'firstname.required' => 'Не указано имя',
            'lastname.required' => 'Не указана фамилия',
            'patronymic.required' => 'Не указано отчество',
            'city.required' => 'Не указан город',
            'address.required' => 'Не указан адрес',
            'phone.required' => "Не указан телефон",
            'email.email' => "Поле e-mail должен быть указан ваш адрес электронной почты в формате xxx@xxx.xxx",
            'firstname.max' => 'Поле имя должно содержать не более 50 символов',
            'lastname.max' => 'Поле фамилия должно содержать не более 50 символов',
            'patronymic.max' => 'Поле отчество должно содержать не более 50 символов',
            'city.max' => 'Поле город должно содержать не более 50 символов',
            'address.max' => 'Поле адрес должно содержать не более 150 символов',
            'phone.max' => "Поле телефон должно содержать не более 20 символов",
            'email.max' => "Поле e-mail должно содержать не более 50 символов"
        ];
    }
}
