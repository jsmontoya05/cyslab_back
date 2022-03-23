<?php

 declare(strict_types=1);

 namespace Src\Credential\Domain\Dtos;

 use Src\Credential\Domain\CredentialEntity;

/**
 * The Data Transfer Object for Credential.
 * It stores the mandatory data for a particular use case - for example ignoring the groups,
 * and ensuring easy serialization.
 */
class CredentialDTO
{
    /**
     * In more complex implementations, the population of the DTO can be the responsibilty
     * of an Assembler object, which would also break any dependency between Credential and CredentialDTO.
     */
    public function __construct(CredentialEntity $credentialEntity)
    {
            $this->id = $credentialEntity->credentialId()->value();
            $this->client_id = $credentialEntity->clientId()->value();
            $this->client_secret = $credentialEntity->clientSecret()->value();
            $this->resource = $credentialEntity->resource()->value();
            $this->subscription_id = $credentialEntity->subscriptionId()->value();
            $this->tenant = $credentialEntity->tenant()->value();
            $this->grant_type = $credentialEntity->grantType()->value();
            $this->active = $credentialEntity->active()->value();
    }


    // there are no setters because this use cases does not require modification of data
    // however, in general DTOs do not need to be immutable.
}

