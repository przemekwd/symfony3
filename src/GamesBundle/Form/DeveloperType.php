<?php

namespace GamesBundle\Form;

use GamesBundle\Entity\DeveloperRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeveloperType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Name',
                'attr' => [
                    'class' => 'form-control mb-2'
                ],
            ])
            ->add('country', ChoiceType::class, [
                'choices' => DeveloperRepository::COUNTRIES,
                'attr' => [
                    'class' => 'form-control mb-2'
                ],
            ])
            ->add('description', null, [
                'attr' => [
                    'class' => 'form-control mb-2'
                ],
                'required' => false,
            ])
            ->add('created', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control js-datepicker mb-2'
                ],
            ])
            ->add('logo', FileType::class, [
                'attr' => [
                    'class' => 'btn btn-default mb-2',
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'GamesBundle\Entity\Developer'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gamesbundle_developer';
    }

}
