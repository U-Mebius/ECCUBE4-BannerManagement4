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

namespace Plugin\BannerManagement4\Tests\Admin\Web;

use Eccube\Tests\Web\Admin\AbstractAdminWebTestCase;

/**
 * Class BannerControllerTest.
 */
class BannerControllerTest extends AbstractAdminWebTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Test render index.
     */
    public function testIndex()
    {
        $this->client->request('GET', $this->generateUrl('admin_content_banner'));
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
}
