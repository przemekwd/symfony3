<?php

namespace GamesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
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
                    'class' => 'form-control mb-2',
                ],
                'label' => 'game.form.name',
                'translation_domain' => 'GamesBundle',
            ])
            ->add('description', null, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'label' => 'game.form.description',
                'translation_domain' => 'GamesBundle',
            ])
            ->add('year', null, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'label' => 'game.form.year',
                'translation_domain' => 'GamesBundle',
            ])
            ->add('developer', null, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'label' => 'game.form.developer',
                'translation_domain' => 'GamesBundle',
            ])
            ->add('cover', FileType::class, [
                'attr' => [
                    'class' => 'btn btn-default mb-2',
                ],
                'label' => 'game.form.cover',
                'translation_domain' => 'GamesBundle',
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'GamesBundle\Entity\Game'
        ]);
    }

    /**
     * @return string
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'gamesbundle_game';
    }

}
