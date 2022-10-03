<?php

namespace App\Form;

use App\Entity\Reponse;
use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'label' => "Titre de la réponse",
            'row_attr' => [
                'class' => "mb-3 form-floating"
            ],
            'attr' => [
                'placeholder' => "Titre de la réponse"
            ]
        ])
        // EntityType permet de gérer une association dans un formulaire
        ->add('question', EntityType::class, [
            // On doit indiquer le paramètre class pour définir l'entité associée
            'class' => Question::class,
            // choice_label définit quel est le champ à afficher
            'choice_label' => 'title',
        ])
        ->add('submit', SubmitType::class, [
            'label' => "Créer"
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reponse::class,
        ]);
    }
}
