<?php

namespace Plugin\BannerManagement4;

use Eccube\Event\TemplateEvent;
use Plugin\BannerManagement4\Repository\BannerRepository;
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
     * コンストラクタ
     *
     * @param BannerRepository $bannerRepository
     */
    public function __construct(
        BannerRepository $bannerRepository,
        MobileDetector $mobileDetector
    ) {
        $this->bannerRepository = $bannerRepository;
        $this->mobileDetector = $mobileDetector;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'index.twig' => ['onIndexTwig',]
        ];
    }


    public function onIndexTwig(TemplateEvent $event) {

        if ($this->mobileDetector->isMobile()) {
            $Banners = $this->bannerRepository->getBanners(2);
            if (empty($Banners)) {
                $Banners = $this->bannerRepository->getBanners(1);
            }
        } else {
            $Banners = $this->bannerRepository->getBanners(1);
        }
        $event->setParameter('TopBanners', $Banners);
        $event->addAsset('@BannerManagement4/index_css.twig');
        $event->addSnippet('@BannerManagement4/index_slider.twig');
    }
}
