<?php

declare(strict_types=1);

namespace Src\Credential\Infrastructure;


use App\Models\Credential;
use Src\Credential\Domain\Contracts\CredentialRepository;
use Src\Credential\Domain\CredentialEntity;
use Src\Credential\Domain\CredentialId;


final class EloquentCredentialRepository implements CredentialRepository
{
    private $model;

    public function __construct()
    {
        $this->model = new Credential();
    }

    public function search(CredentialId $credentialId): array
    {
        return $this->model->findOrFail($credentialId->value())->toArray();
    }

    public function searchActive(): array
    {   $array = $this->model->where('active',1)->first();
        return !empty($array) ? $array->toArray():[];
    }

    public function save(CredentialEntity $credentialEntity): void
    {
        $this->model->fill($credentialEntity->toArray());
        $this->model->save();
    }
}
