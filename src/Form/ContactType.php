<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Voornaam*',
                'attr' => ['autocomplete' => 'given-name', 'placeholder' => 'Voornaam...']
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Achternaam*',
                'attr' => ['autocomplete' => 'family-name', 'placeholder' => 'Achternaam...']
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mailadres*',
                'attr' => ['autocomplete' => 'email', 'placeholder' => 'E-mailadres...']
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Vul hier jouw vraag of opmerking in*',
                'attr' => ['autocomplete' => 'off', 'placeholder' => 'Bericht...']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Versturen',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
