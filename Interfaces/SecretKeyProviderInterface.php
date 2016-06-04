<?php

namespace Trinity\MessagesBundle\Interfaces;

/**
 * Interface SecretKeyProviderInterface
 * @package Trinity\MessagesBundle\Interfaces
 */
interface SecretKeyProviderInterface
{
    /**
     * @param string $clientId
     *
     * @return string Secret key
     */
    public function getSecretKey(string $clientId);
}