<?php

declare(strict_types=1);

namespace App\Service\Bill;

use App\Entity\Bill;
use App\Entity\Property;
use App\Repository\BillRepository;

class BillCreateService
{
    public function __construct(
        private BillRepository $repository,
        private SendBillEmailNotificationService $billEmailNotificationService
    ) {
    }

    public function create(Bill $bill, Property $property): Bill
    {
        $bill->setProperty($property);
        $this->repository->save($bill, true);
        $this->billEmailNotificationService->send($bill);
        return $bill;
    }
}