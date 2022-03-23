<?php

declare(strict_types=1);

namespace Src\Credential\Domain;


final class GrantType
{
    /**
     * @var string
     */
    private $grantType;

    public function __construct(string $grantType)
    {
        $this->grantType = $grantType;
    }

    public function value()
    {
        return $this->grantType;
    }

    /**
     * @param string $grantType
     */
    public function setGrantType(string $grantType): void
    {
        if ($grantType < 0) {
            throw new IdNotFound($grantType);
        }

        $this->grantType = $grantType;
    }
}
