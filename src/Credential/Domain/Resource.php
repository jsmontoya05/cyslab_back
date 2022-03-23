<?php

declare(strict_types=1);

namespace Src\Credential\Domain;


final class Resource
{
    /**
     * @var string
     */
    private $resource;

    public function __construct(string $resource)
    {
        $this->resource = $resource;
    }

    public function value()
    {
        return $this->resource;
    }

    /**
     * @param string $resource
     */
    public function setResource(string $resource): void
    {
        if ($resource < 0) {
            throw new IdNotFound($resource);
        }

        $this->resource = $resource;
    }
}
