<?php

namespace App\DTO;

use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUpdateUser
{

    #[Groups(["create"])]
    #[Assert\Length(
        min:2,
        minMessage: "Name darf nicht kürzer als 4 Zeichen sein",
        max: 255,
        maxMessage: "Name darf nicht länger als 255 Zeichen sein",
        groups: ['create'])]
    #[Assert\NotBlank(message: "Name ist Pflicht", groups: ["create"])]
    public ?string $name = null;


    public ?string $username = null;

    #[Assert\NotBlank(message: "Passwort ist Pflicht", groups: ["create", "update"])]
    public ?string $password = null;

    public ?bool $is_admin = false;
}