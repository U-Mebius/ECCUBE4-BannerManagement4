<?php

/*
 * This file is part of BannerManagement42
 *
 * Copyright(c) U-Mebius Inc. All Rights Reserved.
 *
 * https://umebius.com/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\BannerManagement42;

use Detection\MobileDetect;
use Eccube\Event\TemplateEvent;
use Plugin\BannerManagement42\Repository\BannerRepository;
use Plugin\BannerManagement42\Repository\ConfigRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Event implements EventSubscriberInterface
{
    /**
     * @var BannerRepository
     */
    protected $bannerRepository;

    /**
     * @var MobileDetect
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
        MobileDetect $mobileDetector
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
        $PcBanners = $this->bannerRepository->getBanners(1, true);
        $SpBanners = $this->bannerRepository->getBanners(2, true);

        $event->setParameter('PcBanners', $PcBanners);
        $event->setParameter('SpBanners', $SpBanners);

        if ($this->mobileDetector->isMobile()) {
            $Banners = $SpBanners;
            if (empty($Banners)) {
                $Banners = $PcBanners;
            }
        } else {
            $Banners = $PcBanners;
        }
        $event->setParameter('TopBanners', $Banners);

        if (count($Banners)) {
            $Config = $this->configRepository->get();
            if ($Config && $Config->getReplaceAutomatically()) {
                $event->addAsset('@BannerManagement42/index_css.twig');
                $event->addSnippet('@BannerManagement42/index_slider.twig');
            }
        }
    }
}
