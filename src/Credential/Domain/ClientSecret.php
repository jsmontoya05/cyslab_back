<?php

declare(strict_types=1);

namespace Src\Credential\Domain;


final class ClientSecret
{
    /**
     * @var string
     */
    private $clientSecret;

    public function __construct(string $clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    public function value()
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     */
    public function setClientSecret(string $clientSecret): void
    {
        if ($clientSecret < 0) {
            throw new IdNotFound($clientSecret);
        }

        $this->clientSecret = $clientSecret;
    }
}
