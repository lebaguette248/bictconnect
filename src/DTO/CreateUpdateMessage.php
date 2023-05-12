<?php

namespace App\DTO;

use App\Validator\UserDoesExist;

class CreateUpdateMessage
{
    public ?string $title = null;

    public ?string $content = null;
    #[UserDoesExist]
    public ?int $id_user;
}