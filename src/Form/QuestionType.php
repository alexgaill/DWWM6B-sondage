<?php

namespace App\Form;

use App\Entity\Sondage;
use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Titre de la question",
                'row_attr' => [
                    'class' => "mb-3 form-floating"
                ],
                'attr' => [
                    'placeholder' => "Titre de la question"
                ]
            ])
            // EntityType permet de gérer une association dans un formulaire
            ->add('sondage', EntityType::class, [
                // On doit indiquer le paramètre class pour définir l'entité associée
                'class' => Sondage::class,
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
            'data_class' => Question::class,
        ]);
    }
}
