<?php

namespace Plugin\BannerManagement4;

use Eccube\Plugin\AbstractPluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PluginManager.
 */
class PluginManager extends AbstractPluginManager
{
    const VERSION = '1.0.0';
    /**
     * Install the plugin.
     *
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function install(array $meta, ContainerInterface $container)
    {
        dump('install '.self::VERSION);
    }

    /**
     * Update the plugin.
     *
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function update(array $meta, ContainerInterface $container)
    {
        $entityManager = $container->get('doctrine')->getManager();
        dump('update ' . self::VERSION);
        $this->migration($entityManager->getConnection(), $meta['code']);
    }

    /**
     * Enable the plugin.
     *
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function enable(array $meta, ContainerInterface $container)
    {
        $entityManager = $container->get('doctrine')->getManager();
        dump('enable '.self::VERSION);
        $this->migration($entityManager->getConnection(), $meta['code']);
    }

    /**
     * Disable the plugin.
     *
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function disable(array $meta, ContainerInterface $container)
    {
        $entityManager = $container->get('doctrine')->getManager();
        dump('disable '.self::VERSION);
        $this->migration($entityManager->getConnection(), $meta['code'], '0');
    }

    /**
     * Uninstall the plugin.
     *
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function uninstall(array $meta, ContainerInterface $container)
    {
        dump('uninstall '.self::VERSION);
    }
}
