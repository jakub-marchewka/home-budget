<?php

declare(strict_types=1);

namespace App\Service\Bill;

use App\Entity\Bill;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class SendBillEmailNotificationService
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function send(Bill $bill)
    {
        $paidBy = $bill->getPaidBy();
        $allTenants = $bill->getProperty()->getTenants();
        $toSendArray = $this->getSendListArray($paidBy, $allTenants);
        dump($toSendArray);
        $this->sendEmails($toSendArray, $bill);
    }

    protected function getSendListArray(Collection $paidBy,Collection $allTenants): ArrayCollection
    {
        $toSend = new ArrayCollection();
        foreach ($allTenants as $tenant) {
            if (!$paidBy->contains($tenant)) {
                $toSend->add($tenant);
            }
        }
        return $toSend;
    }

    protected function sendEmails(ArrayCollection $toSendArray, Bill $bill): void
    {
        foreach ($toSendArray as $tenant) {
            $email = (new TemplatedEmail())
                ->to(new Address($tenant->getEmail()))
                ->subject('Pojawił się nowy rachunek do zapłaty.')
                ->htmlTemplate('email/newBillEmail.html.twig')
                ->context([
                    'bill' => $bill,
                ]);
            $this->mailer->send($email);
        }
    }
}