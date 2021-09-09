<?php

namespace App\Form;

use App\Entity\OfferCombination;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferCombinationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', IntegerType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('time', IntegerType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
                'choices' => [
                    'Brak obszaru' => '0',
                    'Twarz' => '1',
                    'Twarz + Oczy' => '2',
                    'Twarz + Szyja' => '3',
                    'Twarz + Szyja + Dekolt' => '4',
                    'Szyja' => '5',
                    'Oczy' => '6',
                    'Nos' => '7',
                    'Dłonie' => '8',
                    'Ciało' => '9'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OfferCombination::class,
        ]);
    }
}
