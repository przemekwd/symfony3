<?php

namespace BlogBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'attr' => [
                    'class' => 'form-control mb-2'
                ],
                'required' => true,
                'label' => 'post.form.title',
                'translation_domain' => 'BlogBundle',
            ])
            ->add('content', null, [
                'attr' => [
                    'class' => 'form-control mb-2'
                ],
                'required' => true,
                'label' => 'post.form.content',
                'translation_domain' => 'BlogBundle',
            ])
            ->add('image', FileType::class, [
                'attr' => [
                    'class' => 'btn btn-default mb-2',
                ],
                'required' => true,
                'label' => 'post.form.image',
                'translation_domain' => 'BlogBundle',
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'BlogBundle\Entity\Post'
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'blogbundle_post';
    }

}