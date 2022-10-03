<?php

namespace App\Form;

use App\Entity\Sondage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SondageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Titre de l'article",
                'row_attr' => [
                    'class' => "mb-3 form-floating"
                ],
                'attr' => [
                    'placeholder' => "Titre de l'article"
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Créer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sondage::class,
        ]);
    }
}
