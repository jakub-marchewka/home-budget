<?php

declare(strict_types=1);

namespace App\Controller\Bill;

use App\Entity\Bill;
use App\Repository\BillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BillDeleteController extends AbstractController
{
    #[Route('/portal/bill/delete/{bill}', name: 'app_bill_delete')]
    public function __invoke(Bill $bill, BillRepository $repository): JsonResponse
    {
        if ($bill->getProperty()->getOwner() === $this->getUser()) {
            $repository->remove($bill, true);
            return $this->json(['status' => 'success' ]);
        }

        return $this->json(['status' => 'error' ]);
    }
}