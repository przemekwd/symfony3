<?php

namespace GamesBundle\Form;

use Doctrine\ORM\EntityManager;
use GamesBundle\Entity\DeveloperRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeveloperType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'attr' => [
                    'class' => 'form-control mb-2'
                ],
                'label' => 'developer.form.name',
                'translation_domain' => 'GamesBundle',
            ])
            ->add('country', ChoiceType::class, [
                'choices' => DeveloperRepository::COUNTRIES,
                'attr' => [
                    'class' => 'form-control mb-2'
                ],
                'label' => 'developer.form.country',
                'translation_domain' => 'GamesBundle',
            ])
            ->add('description', null, [
                'attr' => [
                    'class' => 'form-control mb-2'
                ],
                'required' => false,
                'label' => 'developer.form.description',
                'translation_domain' => 'GamesBundle',
            ])
            ->add('created', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control js-datepicker mb-2'
                ],
                'label' => 'developer.form.founded',
                'translation_domain' => 'GamesBundle',
            ])
            ->add('logo', FileType::class, [
                'attr' => [
                    'class' => 'btn btn-default mb-2',
                ],
                'label' => 'developer.form.cover',
                'translation_domain' => 'GamesBundle',
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'GamesBundle\Entity\Developer'
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'gamesbundle_developer';
    }

}
