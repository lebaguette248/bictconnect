<?php

namespace App\Controller;

use App\DTO\CreateUpdateUser;
use App\DTO\FilterUser;
use App\DTO\Mapper\ShowUserMapper;
use App\DTO\ShowUser;
use App\Entity\User;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


#[Route("/api", name: "api_")]
class UserController extends AbstractFOSRestController
{


    /**
     * Constructor
     * @param SerializerInterface $serializer
     * @param UserRepository $repository
     * @param ShowUserMapper $mapper
     * @param ValidatorInterface $validator
     */
    public function __construct(private SerializerInterface $serializer,        //constructor
                                private UserRepository $repository,
                                private ShowUserMapper $mapper,
                                private ValidatorInterface $validator)  {}


    /**
     * Gets Registered users with Username
     * @param Request $request
     * @return JsonResponse
     */
    #[Get(requestBody: new RequestBody(
        content: new JsonContent(
            ref: new Model(type: FilterUser::class))))]
    #[Response(
        response: 200,
        description: "Gibt alle user aus",
        content:
        new JsonContent(
            type: 'array',
            items: new Items(ref: new Model(type: ShowUser::class))))]
    #[Rest\Get('/user', name: 'app_users')]
    public function index(Request $request): JsonResponse           //Get function
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













    /**
     * Post function vor Creating
     * @param Request $request
     * @return JsonResponse
     */
    #[Post(requestBody: new RequestBody(
        content: new JsonContent(
            ref: new Model(type: CreateUpdateUser::class))))]
    #[Response(
        response: 200,
        description: "Erstellter User",
        content:
        new JsonContent(
            type: 'string'))]

    #[Rest\Post('/user', name: 'app_users_post')]                           //create/post function, handles writing info to database
    public function create(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), CreateUpdateUser::class, "json");
        $errors = $this->validator->validate($dto, groups: ["create"]);
        if($errors->count() > 0)
        {
            $errorsStringarray = [];
            foreach($errors as $error)
            {
                $errorsStringarray[] = $error->getMessage();
            }
            return $this->json($errorsStringarray, status: 400);
        }


        $userwithusername = $this->repository->findBy(["username"=>$dto->username]);        //sucht nach username mit gleichen namen und speichert ihn in $userwithusername
        if($userwithusername)
        {
            return $this->json("username bereits vorhanden");
        }


        $entity = new User();
        $entity->setName($dto->name);
        $entity->setUsername($dto->username);

        $hashedPassword = $passwordHasher->hashPassword($entity, $dto->password);
        $entity->setPassword($hashedPassword);


        if($dto->is_admin)
        {
            $entity->setRoles(["ROLE_ADMIN", "ROLE_USER"]);
        }
        else {
            $entity->setRoles(["ROLE_USER"]);
        }


        $this->repository->save($entity, true);

        $response =[
            "success" => "User {$dto->username} hat funktioniert",
            "entity" => $this->serializer->serialize($entity, "json")
        ];

        return (new JsonResponse())->setContent(json_encode($response));
//        return $this->json("Postaktion des Users {$dto->username} hat funktioniert");
    }












    #[Put(requestBody: new RequestBody(
        content: new JsonContent(
            ref: new Model(type: CreateUpdateUser::class))))]
    #[Response(
        response: 200,
        description: "Bearbeitung von von User mit ID",
        content:
        new JsonContent(
            type: 'string'))]
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
    public function delete($id, Request $request): JsonResponse
    {
        $entityToDelete = $this->repository->find($id);
        $this->repository->remove($entityToDelete, true);



        return $this->json("delete für {$entityToDelete->getUsername()} hat Funktioniert");
    }
}
