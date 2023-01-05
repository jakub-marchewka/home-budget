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

class BillCreateController extends AbstractController
{
    #[Route('/portal/bill/create', name: 'app_bill_create')]
    public function __invoke(Request $request, BillCreateService $createService): JsonResponse
    {
        $bill = new Bill();
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
        ]);
        return $this->json(['status' => 'error', 'form' => $view]);
    }
}