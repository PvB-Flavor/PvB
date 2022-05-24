<?php

namespace App\Form;

use App\Entity\Research;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ResearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titel',
                'attr' => ['placeholder' => 'Titel...']
            ])
            ->add('ongoing', ChoiceType::class, [
                'choices'  => [
                    'Ja' => true,
                    'Nee' => false,
                ],
                'label' => 'Lopend',
                'attr' => ['placeholder' => 'Lopend...']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Beschrijving',
                'attr' => ['placeholder' => 'Beschrijving...']
            ])
            ->add('formLink', UrlType::class, [
                'label' => 'Form Link',
                'attr' => ['placeholder' => 'Link naar formulier...']
            ])
            ->add('image', FileType::class, [
                'label' => 'Achtergrond image',
                'mapped' => false,
                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '5000k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Selecteer een geldig image bestand.',
                    ])
                ],
            ])
            ->add('companyImage', FileType::class, [
                'label' => 'Bedrijf image',
                'mapped' => false,
                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '5000k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Selecteer een geldig image bestand.',
                    ])
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Versturen',
                'attr' => ['style' => 'display: inline-block;']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Research::class,
        ]);
    }
}
