<?php

namespace App\Validator;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UserDoesExistValidator extends ConstraintValidator
{
    public function __construct(private UserRepository $repository){}

    public function validate($idUser, Constraint $constraint){
        $user = $this->repository->find($idUser);

        if(!$user)  {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter("{{ userId }}", $idUser)
                ->addViolation();
        }
    }

}