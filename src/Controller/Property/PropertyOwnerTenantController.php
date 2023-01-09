<?php

declare(strict_types=1);

namespace App\Controller\Property;

use App\Entity\TenantInvite;
use App\Form\TenantInviteType;
use App\Service\Property\SendInviteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyOwnerTenantController extends AbstractController
{
    #[Route('/portal/property/tenant/owner', name: 'app_property_tenant_owner')]
    public function __invoke(Request $request, SendInviteService $sendInviteService): RedirectResponse|Response
    {
        if ($this->getUser() !== $this->getUser()->getCurrentProperty()->getOwner()) {
            return $this->redirectToRoute('app_property_index');
        }
        $tenantInvite = new TenantInvite();
        $tenantInvite->setProperty($this->getUser()->getCurrentProperty());
        //TODO invisible validation from uniqenity
        $form = $this->createForm(TenantInviteType::class, $tenantInvite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sendInviteService->invite($this->getUser(), $tenantInvite);
            $this->addFlash('success', 'Zaproszenie zostało wysłane.');
            return $this->redirectToRoute('app_property_index');
        }
        return $this->render('property/propertyOwnerTenant.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}