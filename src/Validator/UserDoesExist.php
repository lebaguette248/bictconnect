<?php

namespace App\Validator;


use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UserDoesExist extends Constraint
{
    public string $message = "Der User mit ID {{ userID }} existiert nicht ";
}