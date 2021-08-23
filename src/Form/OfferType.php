<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Offer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('describtion', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('aftercare', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('category', EntityType::class, array(
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
