<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question', TextType::class, [
                'label' => 'Vraag',
                'attr' => ['placeholder' => 'Vraag...']
            ])
            ->add('required', ChoiceType::class, [
                'label' => 'Vereist',
                'choices' => [
                    'Ja' => true,
                    'Nee' => false,
                ],
            ])
            ->add('fullWidth', ChoiceType::class, [
                'label' => 'Volledige breedte',
                'choices' => [
                    'Ja' => true,
                    'Nee' => false,
                ],
                'help' => 'Indien deze optie op ja staat, neemt dit veld in het inschrijf-formulier de volledige breedte.',
            ])
            ->add('inputType', ChoiceType::class, [
                'label' => 'Type vraag',
                'choices' => [
                    'Tekst veld' => 'text',
                    'Selectie' => 'select',
                    'Email' => 'email',
                    'Datum' => 'date',
                    'Nummer' => 'number'
                ],
            ])
            ->add('options', TextType::class, [
                'label' => 'Opties (Alleen invullen indien selectie als type is geselecteerd)',
                'required' => false,
                'help' => 'Scheidt de opties met een comma. Voorbeeld: BureauProfiel,Selectie,Nieuwe vraag',
            ])
            ->add('Opslaan', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'      => Question::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'question_item',
        ]);
    }
}
