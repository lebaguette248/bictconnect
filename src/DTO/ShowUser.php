<?php

namespace App\DTO;


use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Property;

class ShowUser
{
    public ?string $name = null;

    public ?string $username = null;

    public ?string $password = null;

    #[Property(
    "messages",
    type: "array",
    items: new Items(
    ref: new Model(
    type: ShowMessage::class)
        ))]
    public  $messages = [];


}