<?php

namespace Plugin\BannerManagement4;

use Eccube\Common\EccubeNav;

class Nav implements EccubeNav
{
    /**
     * @return array
     */
    public static function getNav()
    {
        return [
            'content' => [
                'children' => [
                    'banner' => [
                        'id' => 'banner',
                        'name' => 'banner.admin.title',
                        'url' => 'admin_content_banner',
                    ],
                ],
            ],
        ];
    }
}
