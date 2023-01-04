<?php

declare(strict_types=1);

namespace App\Service\Property;

use App\Entity\User;
use App\Repository\PropertyRepository;
use App\Repository\UserRepository;
use Exception;

class ChangeCurrentPropertyService
{
    public function __construct(private UserRepository $userRepository, private PropertyRepository $propertyRepository)
    {
    }

    /** @throws Exception */
    public function change(User $user, ?string $propertyId): User
    {
        if (empty($propertyId)) {
            throw new Exception('Wystąpił błąd.');
        }
        $property = $this->propertyRepository->find($propertyId);
        if (empty($property)) {
            throw new Exception('Wystąpił błąd.');
        }
        $user->setCurrentProperty($property);
        $this->userRepository->save($user, true);
        return $user;
    }
}