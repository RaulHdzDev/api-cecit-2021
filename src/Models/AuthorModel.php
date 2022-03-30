<?php

namespace App\Models;

class AuthorModel
{
    public $authorId;
    public $projectId;
    public $name;
    public $firstLastName;
    public $secondLastName;
    public $address;
    public $suburb;
    public $postalCode;
    public $curp;
    public $rfc;
    public $phone;
    public $username;
    public $email;
    public $password;
    public $city;
    public $locality;
    public $school;
    public $facebook;
    public $twitter;
    public $englishLevel;

    public function __construct(array $authorParams)
    {
        $this->authorId = $authorParams['author_id'] ?? 0;
        $this->projectId = $authorParams['project_id'] ?? 0;
        $this->name = $authorParams['name_author'] ?? '';
        $this->firstLastName = $authorParams['last_name'] ?? '';
        $this->secondLastName = $authorParams['second_last_name'] ?? '';
        $this->address = $authorParams['address'] ?? '';
        $this->suburb = $authorParams['suburb'] ?? '';
        $this->postalCode = $authorParams['postal_code'] ?? '';
        $this->curp = $authorParams['curp'] ?? '';
        $this->rfc = $authorParams['rfc'] ?? '';
        $this->phone = $authorParams['phone_contact'] ?? '';
        $this->username = $authorParams['user_name'] ?? '';
        $this->email = $authorParams['email'] ?? '';
        $this->password = $authorParams['password'] ?? '';
        $this->city = $authorParams['city'] ?? '';
        $this->locality = $authorParams['locality'] ?? '';
        $this->school = $authorParams['school'] ?? '';
        $this->facebook = $authorParams['facebook'] ?? '';
        $this->twitter = $authorParams['twitter'] ?? '';
        $this->englishLevel = $authorParams['levelEnglish'] ?? '';
    }
}
