<?php

namespace App\DTO\Mapper;



use App\DTO\ShowMessage;

class ShowMessageMapper extends BaseMapper
{

    public function mapEntityToDTO(object $entity)  :object
    {
        $dto = new ShowMessage();
        $dto->title = $entity->getTitle();
        $dto->content = $entity->getContent();
        $dto->user = $entity->getUser()->getUsername();

        return $dto;
    }
}