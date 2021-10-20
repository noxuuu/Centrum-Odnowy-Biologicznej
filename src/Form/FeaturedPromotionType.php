<?php

namespace App\Form;

use App\Entity\FeaturedPromotion;
use App\Entity\Promotion;
use App\Service\formChoicesLoader;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeaturedPromotionType extends AbstractType
{
    private $formChoicesLoader;


    public function __construct(formChoicesLoader $formChoicesLoader)
    {
        $this->formChoicesLoader = $formChoicesLoader;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('promotion', EntityType::class, [
                'class' => Promotion::class,
                'choice_label' => function ($promotion) {
                    $type = $this->formChoicesLoader->getTypeString($promotion->getOfferCombination()->getType());

                    return $promotion->getOfferCombination()->getOffer()->getName().' - '.$type.' | '.$promotion->getNewPrice().' zł';
                },
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FeaturedPromotion::class,
        ]);
    }
}
