<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace Plugin\BannerManagement4\Form\Type\Admin;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Eccube\Common\EccubeConfig;
use Plugin\BannerManagement4\Entity\Banner;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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


    public function __construct(\Eccube\Common\EccubeConfig $eccubeConfig)
    {
        $this->eccubeConfig = $eccubeConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, array(
                'label' => '画像',
                'required' => false,
                'constraints' => array(

                ),
            ))
            ->add('file_name', HiddenType::class, array(
                'error_bubbling' => false,
            ))
            ->add('alt', TextType::class, array(
                'label' => 'ALT',
                'required' => true,
                'constraints' => array(
                    new Assert\Length(['max' => $this->eccubeConfig['eccube_mtext_len']]),
                ),
            ))
            ->add('url', TextType::class, array(
                'label' => 'URL',
                'required' => false,
                'constraints' => array(
                    new Assert\Length(['max' => $this->eccubeConfig['eccube_mtext_len']]),
                ),
            ))
            ->add($builder->create('link_method', CheckboxType::class, array(
                'required' => false,
                'label' => '別ウィンドウを開く',
                'value' => '1',
            )))

	        ->add('Field', EntityType::class, array(
		        'class' => 'Plugin\BannerManagement4\Entity\BannerField',
//		        'property_path' => 'name',
		        'label' => '位置',
		        'required' => true,
		        'constraints' => array(
			        new Assert\NotBlank(),
		        ),
	        ))
            ->add('title', TextType::class, array(
                'label' => 'バナータイトル',
                'required' => false,
            ))
            ->add('comment', TextareaType::class, array(
                'label' => 'バナー説明',
                'required' => false,
            ))
            ->add('additional_class', TextType::class, array(
                'label' => '追加class',
                'required' => false,
            ))
        ;

	    $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event)  {
		    $form = $event->getForm();
		    /* @var $Banner Banner */
		    $Banner = $form->getData();

		    if (empty($Banner->getFile()) && empty($Banner->getFileName())){
			    $form['file_name']->addError(new FormError('ファイルを選択してください'));
		    }
	    });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Plugin\BannerManagement4\Entity\Banner',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'admin_banner';
    }
}
