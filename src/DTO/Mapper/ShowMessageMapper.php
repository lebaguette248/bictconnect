<?php

namespace App\DTO\Mapper;



class ShowMessageMapper extends BaseMapper
{

    public function mapEntityToDTO(object $entity)  :object
    {
        $dto = new ShowMessage();
        $dto->title = $entity->gettitle();
        $dto->content = $entity->getcontent();
        $dto->user= $entity->getuser();

        return $dto;
    }
}