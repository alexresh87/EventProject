<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OrderForm extends Component
{
    public $routeName;
    public $order;
    public $buttonText;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($routeName, $order = null, $buttonText = "Отправить")
    {
        $this->routeName = $routeName;
        $this->order = $order;
        $this->buttonText = $buttonText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.order-form.index');
    }

    /**
     * Массив элементов формы
     */
    public function inputs(){
        $items = [
            [
                'title' => 'Укажите ваше ФИО',
                'items' => [
                    [ 'title' => 'Фамилия', 'value' => '', 'name' => 'lastname' ],
                    [ 'title' => 'Имя', 'value' => '', 'name' => 'firstname' ],
                    [ 'title' => 'Отчество', 'value' => '', 'name' => 'patronymic' ]
                ]
            ],
            [
                'title' => 'Укажите ваш город и адрес',
                'items' => [
                    [ 'title' => 'Город', 'value' => '', 'name' => 'city' ],
                    [ 'title' => 'Адрес', 'value' => '', 'name' => 'address' ]
                ]
            ],
            [
                'title' => 'Укажите ваши контактные данные',
                'items' => [
                    [ 'title' => 'Телефон', 'value' => '', 'name' => 'phone' ],
                    [ 'title' => 'E-mail', 'value' => '', 'name' => 'email' ]
                ]
            ]
        ];
        $var_temp = json_encode($items, JSON_FORCE_OBJECT);
        return json_decode($var_temp);
    }
}
