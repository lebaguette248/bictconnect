<?php

namespace App\Controller;

use App\DTO\CreateUpdateMessage;
use App\Entity\Message;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;

use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


#[Route("/api", name: "api_")]
class MessageController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer,
                                private MessageRepository $repository,
                                private UserRepository $userRepository){}


    #[Route('/message', name: 'app_message')]
    public function index(Request $request): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), CreateUpdateMessage::class, "json");

        $entity = new Message();
        $entity->setTitle($dto->title);
        $entity->setContent($dto->content);
        $entity->setUser($dto->user);

        $this->repository->save($entity, true);



        $user = $this->userRepository->find(1); // TODO: set to message dto id field

        $this->repository->save($entity);



        return $this->json("Post Funktioniert");
    }
}
