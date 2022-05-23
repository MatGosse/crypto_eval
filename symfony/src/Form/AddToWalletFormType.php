<?php

namespace App\Form;

use App\Entity\Wallet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Curency;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddToWalletFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('crypto_name',EntityType::class,[
                'class' => Curency::class,
                'placeholder' => 'Séléctionner une crypto',
                'choice_label' => 'Name',
                'choice_value' => 'Slug'
            ])
            ->add('amount', TextType::class, [
                'attr' => [
                    'placeholder'=>'Quantité'
                ]
            ])
            ->add('initial_value', TextType::class, [
                'attr' => [
                    'placeholder'=>'Prix d\'achat'
                ]
            ])
            ->add('ajouter',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        
    }
}
