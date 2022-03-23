<?php

declare(strict_types=1);

namespace Src\Credential\Domain;


final class ClientId
{
    /**
     * @var string
     */
    private $clientId;

    public function __construct(string $clientId)
    {
        $this->clientId = $clientId;
    }

    public function value()
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     */
    public function setClientId(string $clientId): void
    {
        if ($clientId < 0) {
            throw new IdNotFound($clientId);
        }

        $this->clientId = $clientId;
    }
}
