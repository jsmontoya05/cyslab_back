<?php

declare(strict_types=1);

namespace Src\Credential\Domain;


final class CredentialEntity
{
    private CredentialId $credentialId;
    private ClientId $clientId;
    private ClientSecret $clientSecret;
    private Resource $resource;
    private SubscriptionId $subscriptionId;
    private Tenant $tenant;
    private GrantType $grantType;
    private Active $active;

    public function __construct(
        CredentialId $credentialId,
        ClientId $clientId,
        ClientSecret $clientSecret,
        Resource $resource,
        SubscriptionId $subscriptionId,
        Tenant $tenant,
        GrantType $grantType,
        Active $active
        )
    {
        $this->credentialId = $credentialId;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->resource = $resource;
        $this->subscriptionId = $subscriptionId;
        $this->tenant = $tenant;
        $this->grantType = $grantType;
        $this->active = $active;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            new CredentialId($data['id']),
            new ClientId($data['client_id']),
            new ClientSecret($data['client_secret']),
            new Resource($data['resource']),
            new SubscriptionId($data['subscription_id']),
            new Tenant($data['tenant']),
            new GrantType($data['grant_type']),
            new Active($data['active'])
        );
    }

    /**
     * @return CredentialId
     */
    public function credentialId(): CredentialId
    {
        return $this->credentialId;
    }

    /**
     * @return ClientId
     */
    public function clientId(): ClientId
    {
        return $this->clientId;
    }

    /**
     * @return ClientSecret
     */
    public function clientSecret(): ClientSecret
    {
        return $this->clientSecret;
    }

    /**
     * @return Resource
     */
    public function resource(): Resource
    {
        return $this->resource;
    }

    /**
     * @return SubscriptionId
     */
    public function subscriptionId(): SubscriptionId
    {
        return $this->subscriptionId;
    }

     /**
     * @return Tenant
     */
    public function tenant(): Tenant
    {
        return $this->tenant;
    }

     /**
     * @return grantType
     */
    public function grantType(): GrantType
    {
        return $this->grantType;
    }

    /**
     * @return Active
     */
    public function active(): Active
    {
        return $this->active;
    }

    public function toArray(): array
    {
        return [
            'credentialId' => $this->credentialId()->value(),
            'clientId' => $this->clientId()->value(),
            'clientSecret' => $this->clientSecret()->value(),
            'resource' => $this->resource()->value(),
            'subscriptionId' => $this->subscriptionId()->value(),
            'tenant' => $this->tenant()->value(),
            'grantType' => $this->grantType()->value(),
            'active' => $this->active()->value()
        ];
    }
}
