<?php

namespace App\Controller;

use App\DTO\CreateUpdateUser;
use App\DTO\FilterUser;
use App\DTO\Mapper\ShowUserMapper;
use App\Entity\User;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


#[Route("/api", name: "api_")]
class UserController extends AbstractFOSRestController
{
    public function __construct(private SerializerInterface $serializer,
                                private UserRepository $repository,
                                private ShowUserMapper $mapper,
                                private ValidatorInterface $validator)  {

    }

    #[Rest\Get('/user', name: 'app_users')]
    public function index(Request $request): JsonResponse
    {
        $dtofilter = $this->serializer->deserialize(
            $request->getContent(),
            FilterUser::class,
            "json"
        );


        $User = $this->repository->filterAll($dtofilter);

       return (new JsonResponse())->setContent(
           $this->serializer->serialize(
               $this->mapper->mapEntitiesToDTOs($User), "json")
       );
    }

    #[Rest\Post('/user', name: 'app_users_post')]
    public function create(Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), CreateUpdateUser::class, "json");

        $errors = $this->validator->validate($dto, groups: ["create"]);

        if($errors->count() > 0)    {
            $errorsStringarray = [];
            foreach($errors as $error){
                $errorsStringarray[] = $error->getMessage();
            }
            return $this->json($errorsStringarray, status: 400);
        }


        $entity = new User();
        $entity->setName($dto->name);
        $entity->setUsername($dto->username);
        $entity->setPassword($dto->password);

        $this->repository->save($entity, true);

        return $this->json("Post hat funktioniert");
    }

    #[Rest\Put('/user/{id}', name: 'app_users_update')]
    public function update($id,Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), CreateUpdateUser::class, "json");

        $entityToUpdate = $this->repository->find($id);



        $entityToUpdate->setName($dto->name);
        $entityToUpdate->setUsername($dto->username);
        $entityToUpdate->setPassword($dto->password);

        $this->repository->save($entityToUpdate, true);



        return $this->json("Update Funktioniert");
    }

    #[Rest\Delete('/user/{id}', name: 'app_users_delete')]
    public function delete(): JsonResponse
    {



        return $this->json("delete Funktioniert");
    }

}
