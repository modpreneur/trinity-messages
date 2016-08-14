<?php

/*
 * This file is part of the Trinity project.
 *
 */

namespace Trinity\Bundle\MessagesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link * http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     *
     * @throws \RuntimeException
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('trinity_messages');

        $rootNode->children()->scalarNode('sender_identification')->cannotBeEmpty()->isRequired();

        //reference to a service - starting with '@'
        $rootNode->children()->scalarNode('message_user_provider')->cannotBeEmpty()->isRequired()->beforeNormalization()
            //if the string starts with @, e.g. @service.name
            ->ifTrue(
                function ($v) {
                    return is_string($v) && 0 === strpos($v, '@');
                }
            )
            //return it's name without '@', e.g. service.name
            ->then(function ($v) {
                return substr($v, 1);
            });

        //reference to a service - starting with '@'
        $rootNode->children()->scalarNode('secret_key_provider')->cannotBeEmpty()->isRequired()->beforeNormalization()
            //if the string starts with @, e.g. @service.name
            ->ifTrue(
                function ($v) {
                    return is_string($v) && 0 === strpos($v, '@');
                }
            )
            //return it's name without '@', e.g. service.name
            ->then(function ($v) {
                return substr($v, 1);
            });

        return $treeBuilder;
    }
}
