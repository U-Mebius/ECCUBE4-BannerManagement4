<?php

namespace Plugin\BannerManagement4;

use Eccube\Event\TemplateEvent;
use Plugin\BannerManagement4\Repository\BannerRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Event implements EventSubscriberInterface
{

    /**
     * @var BannerRepository
     */
    protected $bannerRepository;

    /**
     * コンストラクタ
     *
     * @param BannerRepository $bannerRepository
     */
    public function __construct(
        BannerRepository $bannerRepository
    ) {
        $this->bannerRepository = $bannerRepository;
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
        $event->setParameter('TopBanners', $this->bannerRepository->getBanners(1));
        $event->addSnippet('@BannerManagement4/index_slider.twig');
    }
}
