<?php

namespace App\Form;

use App\Entity\Bill;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $users = $options['users'];
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nazwa',
            ])
            ->add('priceTotal', NumberType::class, [
                'label' => 'Kwota',
            ])
            ->add('splitOn', NumberType::class, [
                'label' => 'Podział na:',
            ])
            ->add('type')
            ->add('archived', CheckboxType::class, [
                'label' => 'Zaarchiwiziowane',
            ])
            ->add('paidBy', EntityType::class, [
                'label' => 'Zapłacony przez',
                'class' => User::class,
                'choice_label' => 'email',
                'choices' => $users,
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bill::class,
            'users' => [],
        ]);
    }
}
