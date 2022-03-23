<?php

declare(strict_types=1);

namespace Src\Credential\Application;


use Src\Credential\Domain\Contracts\CredentialRepository;
use Src\Credential\Domain\CredentialEntity;

final class FindActiveCredentialUseCase
{
    private CredentialRepository $repository;

    public function __construct(CredentialRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): ?CredentialEntity
    {
        $response = $this->repository->searchActive();
        if (empty($response)) {
            return null;
        }
        return CredentialEntity::fromArray($response);
    }

    private function ensureExist(?array $datos): void
    {
        if (empty($datos)) {

        }
    }
}
