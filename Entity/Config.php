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

namespace Plugin\BannerManagement42\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Config
 *
 * @ORM\Table(name="plg_banner_management42_config")
 * @ORM\Entity(repositoryClass="Plugin\BannerManagement42\Repository\ConfigRepository")
 */
class Config
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private $replace_automatically = true;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getReplaceAutomatically()
    {
        return $this->replace_automatically;
    }

    /**
     * @param string $replace_automatically
     * @return Config
     */
    public function setReplaceAutomatically($replace_automatically)
    {
        $this->replace_automatically = $replace_automatically;
        return $this;
    }

}
