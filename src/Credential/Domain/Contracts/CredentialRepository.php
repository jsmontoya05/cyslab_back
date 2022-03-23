<?php


namespace Src\Credential\Domain\Contracts;

use Src\Credential\Domain\CredentialEntity;
use Src\Credential\Domain\CredentialId;

interface CredentialRepository
{
    public function search(CredentialId $credentialId): array;
    public function searchActive(): array;
    public function save(CredentialEntity $credential): void;
}
