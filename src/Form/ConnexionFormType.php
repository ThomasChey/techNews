<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConnexionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ----- EMAIL -----
            ->add('email', TextType::class, [
                'required' => true, // Pas obligatoire, true par default
                'label' => "Saisissez votre Email",
                'attr' => ['placeholder' => "Email"]
            ])
            // ----- PASSWORD -----
            ->add('password', PasswordType::class, [
                'required' => true, // Pas obligatoire, true par default
                'label' => "Saisissez votre mot de passe",
                'attr' => ['placeholder' => "Mot de Passe"]
            ])
            // ----- SUBMIT -----
            ->add('submit', SubmitType::class, [
                'label' => "Connexion"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_login';
    }

}