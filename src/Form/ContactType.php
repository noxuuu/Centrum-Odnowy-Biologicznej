<?php
/**
 * Created by PhpStorm.
 * Project: NWXStudio
 * User: Patryk Szczepański
 * Date: 14/03/2021
 * Time: 14:44
 */

namespace App\Form;

use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Imię i Nazwisko',
                    'data-error' => 'Wpisz swoje imię'
                ]
            ])
            ->add('number', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Numer telefonu",
                    'data-error' => 'Wpisz numer telefonu'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Adres E-Mail",
                    'data-error' => 'Wpisz adres E-Mail'
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'cols' => 30,
                    'rows' => 5,
                    'placeholder' => "Treśc wiadomości",
                    'data-error' => 'Wpisz treść swojej wiadomości'
                ]
            ]);
    }
}
