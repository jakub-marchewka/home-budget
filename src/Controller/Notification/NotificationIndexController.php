<?php

declare(strict_types=1);

namespace App\Controller\Notification;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationIndexController extends AbstractController
{
    #[Route('/portal/notification', name: 'app_notification_index')]
    public function __invoke(): Response
    {
        return $this->render('notification/notification.html.twig');
    }
}