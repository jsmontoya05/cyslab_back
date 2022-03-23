<?php

declare(strict_types=1);

namespace Src\Credential\Domain;


final class CredentialId
{
    /**
     * @var int
     */
    private $credentialId;

    public function __construct(int $credentialId)
    {
        $this->credentialId = $credentialId;
    }

    public function value()
    {
        return $this->credentialId;
    }

    /**
     * @param int $credentialId
     */
    public function setId(int $credentialId): void
    {
        if ($credentialId < 0) {
            throw new IdNotFound($credentialId);
        }

        $this->credentialId = $credentialId;
    }
}
