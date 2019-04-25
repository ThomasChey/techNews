<?php


namespace App\Form;


use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ----- PRENOM -----
            ->add('prenom', TextType::class, [
                'required' => true, // Pas obligatoire, true par default
                'label' => "Saisissez votre Prénom",
                'attr' => ['placeholder' => "Prénom"]
            ])
//            ------ NOM ------
            ->add('nom', TextType::class, [
                'required' => true, // Pas obligatoire, true par default
                'label' => "Saisissez votre Nom",
                'attr' => ['placeholder' => "Nom"]
            ])
//            ----- EMAIL -----
            ->add('email', TextType::class, [
                'required' => true, // Pas obligatoire, true par default
                'label' => "Saisissez votre Email",
                'attr' => ['placeholder' => "Email"]
            ])
//            ----- PASSWORD -----
            ->add('password', PasswordType::class, [
                'required' => true, // Pas obligatoire, true par default
                'label' => "Saisissez votre mot de passe",
                'attr' => ['placeholder' => "Mot de Passe"]
            ])
//            ----- SUBMIT -----
            ->add('submit', SubmitType::class, [
                'label' => "M'inscrire"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) // Sécurité pour s'assurer que seul un Membre peut être crée
    {
        $resolver->setDefault('data_class', Membre::class);
    }

    public function getBlockPrefix()
    {
        return 'form';
    }


}