<?php

declare(strict_types=1);

namespace Src\Credential\Application;


use Src\Credential\Domain\Contracts\CredentialRepository;
use Src\Credential\Domain\CredentialEntity;
use Src\Credential\Domain\CredentialId;

final class FindCredentialUseCase
{
    private CredentialRepository $repository;

    public function __construct(CredentialRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): ?CredentialEntity
    {
        $response = $this->repository->search(new CredentialId($id));
        $this->ensureExist($response);

        return CredentialEntity::fromArray($response);
    }

    private function ensureExist(?array $datos): void
    {
        if (empty($datos)) {
            // Podría ejecutar excepción EmployeeNotExists o devolver []
        }
    }
}
