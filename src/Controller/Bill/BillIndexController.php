<?php

declare(strict_types=1);

namespace App\Controller\Bill;

use App\Entity\Bill;
use App\Form\BillType;
use App\Repository\BillRepository;
use App\Service\Bill\GetBillsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BillIndexController extends AbstractController
{

    #[Route('/portal/bill', name: 'app_bill_index')]
    public function __invoke(Request $request, GetBillsService $billsService): RedirectResponse|Response
    {
        if (!$this->getUser()->getCurrentProperty()) {
            $this->addFlash('error', 'Nie posiadasz aktywnej nieruchomości');
            return $this->redirectToRoute('app_property_index');
        }
        $form = null;
        if ($this->getUser()->getCurrentProperty()->getOwner() === $this->getUser()) {
            $bill = new Bill();
            $form = $this->createForm(
                BillType::class,
                $bill,
                [
                    'users' => $this->getUser()->getCurrentProperty()->getTenants(),
                ]
            );
            $form->handleRequest($request);
            $form = $form->createView();
        }
        return $this->render('bill/bill.html.twig', [
            'form' => $form,
            'bills' => $billsService->find($this->getUser()->getCurrentProperty()),
        ]);
    }
}