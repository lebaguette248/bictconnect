<?php

namespace App\DTO\Mapper;

use App\DTO\ShowUser;

class ShowUserMapper extends BaseMapper
{

    public function mapEntityToDTO(object $entity)  :object
    {
        $mapper = new ShowMessageMapper();


        $dto = new ShowUser();
        $dto->name = $entity->getname();
        $dto->username = $entity->getUsername();
        $dto->password = $entity->getPassword();

        $dto->messages = $mapper->mapEntitiesToDTOS($entity->getMessages());

        return $dto;
    }
}