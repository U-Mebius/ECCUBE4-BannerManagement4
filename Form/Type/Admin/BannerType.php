<?php

/*
 * This file is part of BannerManagement4
 *
 * Copyright(c) U-Mebius Inc. All Rights Reserved.
 *
 * https://umebius.com/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\BannerManagement4\Form\Type\Admin;

use Eccube\Common\EccubeConfig;
use Plugin\BannerManagement4\Entity\Banner;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class BannerType extends AbstractType
{
    /**
     * @var \Eccube\Common\EccubeConfig
     */
    protected $eccubeConfig;

    public function __construct(EccubeConfig $eccubeConfig)
    {
        $this->eccubeConfig = $eccubeConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, [
                'label' => '画像',
                'required' => false,
                'constraints' => [
                ],
            ])
            ->add('file_name', HiddenType::class, [
                'error_bubbling' => false,
            ])
            ->add('alt', TextType::class, [
                'label' => 'ALT',
                'required' => false,
                'constraints' => [
                    new Assert\Length(['max' => $this->eccubeConfig['eccube_mtext_len']]),
                ],
            ])
            ->add('url', TextType::class, [
                'label' => 'URL',
                'required' => false,
                'constraints' => [
                    new Assert\Length(['max' => $this->eccubeConfig['eccube_mtext_len']]),
                ],
            ])
            ->add($builder->create('link_method', CheckboxType::class, [
                'required' => false,
                'label' => '別ウィンドウを開く',
                'value' => '1',
            ]))

            ->add('Field', EntityType::class, [
                'class' => 'Plugin\BannerManagement4\Entity\BannerField',
                'label' => '位置',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('title', TextType::class, [
                'label' => 'バナータイトル',
                'required' => false,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'バナー説明',
                'required' => false,
            ])
            ->add('additional_class', TextType::class, [
                'label' => '追加class',
                'required' => false,
            ])
            ->add('visible', ChoiceType::class, [
                'choices' => ['admin.common.show' => true, 'admin.common.hide' => false],
                'required' => true,
                'expanded' => false,
            ])
        ;

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            /* @var $Banner Banner */
            $Banner = $form->getData();

            if (empty($Banner->getFile()) && empty($Banner->getFileName())) {
                $form['file_name']->addError(new FormError('ファイルを選択してください'));
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Plugin\BannerManagement4\Entity\Banner',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'admin_banner';
    }
}
