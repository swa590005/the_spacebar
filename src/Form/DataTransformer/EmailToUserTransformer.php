<?php

namespace App\Form\DataTransformer;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EmailToUserTransformer implements DataTransformerInterface
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;
    }

    // to get the email from user object i.e $value
    public function transform($value)
    {
        if(null === $value)
        {
            return '';
        }
        if(!$value instanceof User)
        {
            throw new \LogicException('The UserSelectTextType can only be used with User objects');
        }

        return $value->getEmail();
    }

    // to get the userobject by pasing email address
    public function reverseTransform($value)
    {
        $user=$this->userRepository->findOneBy(['email'=> $value ]);

        if(!$user)
        {
            throw new TransformationFailedException(sprintf(
                'no user found with the email "%s"',
                $value
            ));
        }

        return $user;

    }
}
