<?php

namespace Trinity\Bundle\MessagesBundle\Interfaces;

/**
 * Interface SecretKeyProviderInterface.
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
