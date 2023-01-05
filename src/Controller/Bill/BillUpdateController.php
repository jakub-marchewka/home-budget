<?php

declare(strict_types=1);

namespace App\Controller\Bill;

use App\Entity\Bill;
use App\Form\BillType;
use App\Service\Bill\BillCreateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BillUpdateController extends AbstractController
{
    #[Route('/portal/bill/update/{bill}', name: 'app_bill_update')]
    public function __invoke(Bill $bill, Request $request, BillCreateService $createService): JsonResponse
    {
        $form = $this->createForm(
            BillType::class,
            $bill,
            [
                'users' => $this->getUser()->getCurrentProperty()->getTenants(),
            ]
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $createService->create($bill, $this->getUser()->getCurrentProperty());
            return $this->json(['status' => 'success']);
        }
        $view = $this->renderView('bill/createForm.html.twig', [
            'form' => $form->createView(),
            'type' => 'update',
        ]);
        return $this->json(['status' => 'error', 'form' => $view]);
    }
}