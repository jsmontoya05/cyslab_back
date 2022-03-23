<?php

declare(strict_types=1);

namespace Src\Credential\Domain;


final class SubscriptionId
{
    /**
     * @var string
     */
    private $subscriptionId;

    public function __construct(string $subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
    }

    public function value()
    {
        return $this->subscriptionId;
    }

    /**
     * @param string $subscriptionId
     */
    public function setSubscriptionId(string $subscriptionId): void
    {
        if ($subscriptionId < 0) {
            throw new IdNotFound($subscriptionId);
        }

        $this->subscriptionId = $subscriptionId;
    }
}
