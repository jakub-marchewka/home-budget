<?php

declare(strict_types=1);

namespace App\Controller\Notification;

use App\Entity\Notification;
use App\Form\NotificationType;
use App\Service\Notification\NotificationCreateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NotificationCreateController extends AbstractController
{
    #[Route('/portal/notification/create', name: 'app_notification_create')]
    public function __invoke(Request $request, NotificationCreateService $createService): JsonResponse
    {
        $notification = new Notification();
        $form = $this->createForm(NotificationType::class, $notification)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $createService->create($notification, $this->getUser());
            return $this->json(['status' => 'success']);
        }

        $view = $this->renderView('notification/notificationForm.html.twig', [
            'form' => $form->createView(),
        ]);

        return $this->json(['status' => 'error', 'form' => $view]);
    }
}