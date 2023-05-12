<?php

namespace App\Controller;

use App\DTO\CreateUpdateMessage;
use App\DTO\Mapper\ShowMessageMapper;
use App\Entity\Message;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


#[Route("/api", name: "api_")]
class MessageController extends AbstractFOSRestController
{
    public function __construct(private SerializerInterface $serializer,
                                private ValidatorInterface $validator,       //constructor
                                private MessageRepository $repository,
                                private UserRepository $userRepository,
                                private ShowMessageMapper $mapper){}


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

    #[Rest\Post("/message", "app_message_create")]
    public function create(Request $request) {
        $dto = $this->serializer->deserialize($request->getContent(), CreateUpdateMessage::class, "json");  //handles DTO Deserialization

        $errors = $this->validator->validate($dto);
        
        if($errors->count() > 0){
            return $this->json("Heck.", status: 400);
        }
        $entity = new Message();
        $entity->setTitle($dto->title);
        $entity->setContent($dto->content);

        $user = $this->userRepository->find($dto->id_user);
        $entity->setUser($user);

        $this->repository->save($entity, true);

        $messageJson = $this->serializer->serialize($this->mapper->mapEntityToDTO($entity), "json");

        return (new JsonResponse())->setContent($messageJson);
    }

    #[Rest\Get('/message', name: 'app_messages')]
    public function index(Request $request): JsonResponse           //Get function
    {
        $messages = $this->repository->findAll();

        return $this->json($this->mapper->mapEntitiesToDTOs($messages));
    }


}
