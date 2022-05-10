<?php

namespace App\Form;

use App\Entity\Wallet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class RemoveWalletFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('crypto_name')
            ->add('amount')
            ->add('ajouter',SubmitType::class)
        ;   
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        
    }
}
