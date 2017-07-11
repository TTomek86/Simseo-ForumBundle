<?php

namespace Simseo\ForumBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class SimseoForumExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('simseo_forum.pagination', $config['pagination']);
        $container->setParameter('simseo_forum.pagination.pagename', $config['pagination']["page_name"]);
        $container->setParameter('simseo_forum.preview', $config["preview"]["enabled"]);
        $container->setParameter('simseo_forum.antiflood', $config["antiflood"]["enabled"]);
        $container->setParameter('simseo_forum.antiflood.hours', $config["antiflood"]["hours"]);
        $container->setParameter('simseo_forum.sonata_admin', $config["sonata_admin"]["enabled"]);
        
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
