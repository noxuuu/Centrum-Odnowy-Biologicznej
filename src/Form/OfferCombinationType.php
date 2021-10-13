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
                    'Dekolt' => '7',
                    'Nos' => '8',
                    'Dłonie' => '9',
                    'Ciało' => '10',
                    'Wąsik' => '11',
                    'Broda' => '12',
                    'Policzki' => '13',
                    'Bikini' => '14',
                    'Linia biała' => '15',
                    'Obszar między pośladkami' => '16',
                    'Pachy' => '17',
                    'Plecy' => '18',
                    'Nogi' => '19',
                    'Łydki' => '20',
                    'Uda' => '21',
                    'Brzuch' => '22',
                    'Stopy' => '23',
                    'Pośladki' => '24',
                    'Uda + Pośladki' => '25',
                    'Ramiona' => '26'
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
