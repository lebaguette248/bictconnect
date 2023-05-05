<?php

namespace App\DTO;

class CreateUpdateMessage
{
    public function mapEntityToDTO(object $entity)  :object
    {
        $dto = new ShowMessage();
        $dto->title = $entity->gettitle();
        $dto->content = $entity->getcontent();
        $dto->user = $entity->getuser();

        return $dto;
    }
}