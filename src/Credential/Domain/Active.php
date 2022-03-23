<?php

declare(strict_types=1);

namespace Src\Credential\Domain;


final class Active
{
    /**
     * @var int
     */
    private $active;

    public function __construct(int $active)
    {
        $this->active = $active;
    }

    public function value()
    {
        return $this->active;
    }

    /**
     * @param int $active
     */
    public function setActive(int $active): void
    {
        if ($active < 0) {
            throw new IdNotFound($active);
        }

        $this->active = $active;
    }
}
