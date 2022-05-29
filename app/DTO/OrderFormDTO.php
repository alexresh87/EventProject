<?php
namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class OrderFormDTO extends DataTransferObject{
    public string $firstname;
    public string $lastname;
    public string $patronymic;
    public string $city;
    public string $address;
    public string $phone;
    public string $email;
}