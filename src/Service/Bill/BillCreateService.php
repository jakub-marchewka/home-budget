<?php

declare(strict_types=1);

namespace App\Service\Bill;

use App\Entity\Bill;
use App\Entity\Property;
use App\Entity\User;
use App\Repository\BillRepository;

class BillCreateService
{
    public function __construct(private BillRepository $repository)
    {
    }

    public function create(Bill $bill, Property $property): Bill
    {
        $bill->setProperty($property);
        $this->repository->save($bill, true);
        return $bill;
    }
}