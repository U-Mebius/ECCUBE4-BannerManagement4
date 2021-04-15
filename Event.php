<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\BannerManagement4;

use Eccube\Event\TemplateEvent;
use Plugin\BannerManagement4\Repository\BannerRepository;
use Plugin\BannerManagement4\Repository\ConfigRepository;
use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Event implements EventSubscriberInterface
{
    /**
     * @var BannerRepository
     */
    protected $bannerRepository;

    /**
     * @var MobileDetector
     */
    protected $mobileDetector;

    /**
     * @var ConfigRepository
     */
    private $configRepository;

    /**
     * コンストラクタ
     */
    public function __construct(
        BannerRepository $bannerRepository,
        ConfigRepository $configRepository,
        MobileDetector $mobileDetector
    ) {
        $this->bannerRepository = $bannerRepository;
        $this->configRepository = $configRepository;
        $this->mobileDetector = $mobileDetector;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'index.twig' => ['onIndexTwig'],
        ];
    }

    public function onIndexTwig(TemplateEvent $event)
    {
        if ($this->mobileDetector->isMobile()) {
            $Banners = $this->bannerRepository->getBanners(2);
            if (empty($Banners)) {
                $Banners = $this->bannerRepository->getBanners(1);
            }
        } else {
            $Banners = $this->bannerRepository->getBanners(1);
        }

        if (count($Banners)) {
            $event->setParameter('TopBanners', $Banners);

            $Config = $this->configRepository->get();
            if ($Config && $Config->getReplaceAutomatically()) {
                $event->addAsset('@BannerManagement4/index_css.twig');
                $event->addSnippet('@BannerManagement4/index_slider.twig');
            }
        }
    }
}
