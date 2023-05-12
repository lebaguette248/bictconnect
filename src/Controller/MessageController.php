<?php

namespace App\Controller;

use App\DTO\CreateUpdateMessage;
use App\DTO\FilterUser;
use App\Entity\Message;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Post;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


#[Route("/api", name: "api_")]
class MessageController extends AbstractFOSRestController
{
    public function __construct(private SerializerInterface $serializer,        //constructor
                                private MessageRepository $repository,
                                private UserRepository $userRepository){}


//    #[Post('/message', name: 'app_message')]
//    public function create(Request $request): JsonResponse
//    {
//        $dto = $this->serializer->deserialize($request->getContent(), CreateUpdateMessage::class, "json");  //handles DTO Deserialization
//        $entity = new Message();
//        $entity->setTitle($dto->title);
//        $entity->setContent($dto->content);
//        $entity->setUser($dto->user);
//        $this->repository->save($entity, true);
//        $user = $this->userRepository->find(1); // TODO: set to message dto id field
//        $this->repository->save($entity);
//        return $this->json("Post Funktioniert");
//    }

    #[Rest\Get('/message', name: 'app_users')]
    public function index(Request $request): JsonResponse           //Get function
    {
        global $con = new \PDO(Datenbank scheiss)

        $sql->con = "SELECT * FROM messages WHERE username = :username";
        $sql->bindParam(':username', $username);
        $sql->execute();
        $data = $sql->fetchAll();

        return
    }


}
