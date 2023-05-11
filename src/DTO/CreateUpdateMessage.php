<?php

namespace App\DTO;

use App\Validator\UserDoesExist;

class CreateUpdateMessage
{
    #[UserDoesExist]
    public ?int $id_user;
}