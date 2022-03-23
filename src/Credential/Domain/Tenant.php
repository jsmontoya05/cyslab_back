<?php

declare(strict_types=1);

namespace Src\Credential\Domain;


final class Tenant
{
    /**
     * @var string
     */
    private $tenant;

    public function __construct(string $tenant)
    {
        $this->tenant = $tenant;
    }

    public function value()
    {
        return $this->tenant;
    }

    /**
     * @param string $tenant
     */
    public function setId(string $tenant): void
    {
        if ($tenant < 0) {
            throw new IdNotFound($tenant);
        }

        $this->tenant = $tenant;
    }
}
