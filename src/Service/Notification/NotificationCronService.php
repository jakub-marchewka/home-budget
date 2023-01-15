<?php

declare(strict_types=1);

namespace App\Service\Notification;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class NotificationCronService
{
    public function __construct(
        private NotificationRepository $repository,
        private MailerInterface $mailer,
    ) {
    }

    public function sendEmails(): array
    {
        $notifications = $this->repository->getNotificationsForToday();
        foreach ($notifications as $notification) {
            $this->sendNotificationEmail($notification);
        }
        return $notifications;
    }

    protected function sendNotificationEmail(Notification $notification): void
    {
        $email = (new TemplatedEmail())
            ->to(new Address($notification->getUser()->getEmail()))
            ->subject('Masz nowe powiadomienie.')
            ->htmlTemplate('email/notificationEmail.html.twig')
            ->context([
                'notification' => $notification,
            ]);
        $this->mailer->send($email);
    }
}