<?php

declare(strict_types=1);

namespace App\Service\Property;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

class FindPropertiesService
{
    public function find(User $user): ArrayCollection
    {
        $propertiesOwned = $user->getProperties();
        $propertiesRented = $user->getRentedProperties();
        return new ArrayCollection(array_merge($propertiesOwned->toArray(), $propertiesRented->toArray()));
    }
}