<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Wallet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\WalletRepository;


class RemoveWalletFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('wallet',EntityType::class,[
                'class' => Wallet::class,
                'choice_label' => function($wallet){
                    return $wallet->getCurrency()->getName().' ('.$wallet->getAmount().')';
                },
                'placeholder'=>'Séléctioner une position'
            ])
            ->add('amount', TextType::class, [
                'attr' => [
                    'placeholder'=>'Quantité'
                ]
            ])
            ->add('valider',SubmitType::class)
        ;   
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        
    }
}
