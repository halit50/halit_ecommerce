<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('new_password', RepeatedType::class, [
            'type' => PasswordType::class,
            'mapped' => false, //Pour lui dire qu'il ne doit pas aller chercher le new_password dans mon entité
            'invalid_message'=> 'Le mot de passe et la confirmation doivent être identiques',
            'label' => 'Mon nouveau mot de passe',
            'required' => true,
            'first_options'=>['label'=> 'Mot de passe', 
            'attr' => [
                'placeholder' => 'Merci de saisir votre nouveau mot de passe'
            ]],
            'second_options' => ['label' => 'Confirmez votre nouveau mot de passe',
            'attr' => [
                'placeholder' => 'Confirmez votre nouveau mot de passe'
            ]]
        ] 
        )
        ->add('submit', SubmitType::class, [
            'label' => 'Mettre à jour mon mot de passe',
            'attr' => [
                'class' => 'btn-block btn-info'
            ]
        ])
            ->add('field_name')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
