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
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
            ])
            ->add('description', null, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
            ])
            ->add('year', null, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
            ])
            ->add('developer', null, [
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
            ])
            ->add('cover', FileType::class, [
                'attr' => [
                    'class' => 'form-control filestyle mb-2',
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'GamesBundle\Entity\Game'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'gamesbundle_game';
    }

}
