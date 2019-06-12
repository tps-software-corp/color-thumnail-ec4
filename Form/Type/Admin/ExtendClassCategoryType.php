<?php

namespace Plugin\ColorThumb\Form\Type\Admin;

use Plugin\ColorThumb\Entity\ExtendClassCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Eccube\Form\Type\Admin\ClassCategoryType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class ExtendClassCategoryType extends ClassCategoryType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => $this->eccubeConfig['eccube_stext_len'],
                ]),
            ],
        ])
        ->add('backend_name', TextType::class, [
            'label' => 'classname.label.backend_name',
            'required' => false,
            'constraints' => [
                new Assert\Length([
                    'max' => $this->eccubeConfig['eccube_stext_len'],
                ]),
            ],
        ])
        ->add('color_thumb_hex', TextType::class, [
            'label' => 'classname.label.color_thumb_hex',
            'required' => false,
            'constraints' => [
                new Assert\Length([
                    'max' => $this->eccubeConfig['eccube_stext_len'],
                ]),
            ],
        ])
        ->add('visible', ChoiceType::class, [
            'label' => false,
            'choices' => ['common.label.display' => true, 'common.label.hide' => false],
            'required' => true,
            'expanded' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExtendClassCategory::class,
        ]);
    }
}
