<?php

namespace App\Form;


use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

//            --------- TITRE --------
            ->add('titre', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Titre de l'Article"
                ]
            ])

//            --------- CATEGORIE --------
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'label' => false,
            ])

//            --------- CONTENU --------
            ->add('contenu', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => "Contenu de l'Article"
                ]
            ])

//            --------- IMAGE --------
            ->add('featuredImage', FileType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'dropify'
                ]
            ])

//            --------- SPECIAL --------
            ->add('special', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-on' => 'Oui',
                    'data-off' => 'Non'
                ]
            ])

//            --------- SPOTLIGHT --------
            ->add('spotlight', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-on' => 'Oui',
                    'data-off' => 'Non'
                ]
            ])

//            --------- SUBMIT --------
            ->add('submit', SubmitType::class, [
                'label' => 'Publier mon Article'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        # Ici, mon formulaire ArticleFormType travaillera OBLIGATOIREMENT avec des instances de App/Entity/article.
        $resolver->setDefault('data_class', Article::class);
    }

    public function getBlockPrefix()
    {
        # Permet de préfixer les id et name des formulaires
        return 'form';
    }

}