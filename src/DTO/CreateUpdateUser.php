<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUpdateUser
{
    #[Assert\NotBlank(message: "Name ist Pflicht", groups: ["create"])]
    public ?string $name = null;


    public ?string $username = null;

    #[Assert\NotBlank(message: "Passwort ist Pflicht", groups: ["create", "update"])]
    public ?string $password = null;



}