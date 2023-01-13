<?php

declare(strict_types=1);

namespace App\Controller\Notification;

use App\Entity\Notification;
use App\Form\NotificationType;
use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationIndexController extends AbstractController
{
    #[Route('/portal/notification', name: 'app_notification_index')]
    public function __invoke(Request $request, NotificationRepository $repository): Response
    {
        $notification = new Notification();
        $form = $this->createForm(NotificationType::class, $notification)->handleRequest($request);

        return $this->render('notification/notification.html.twig', [
            'form' => $form->createView(),
            'notifications' => $repository->findBy(['user' => $this->getUser()]),
        ]);
    }
}