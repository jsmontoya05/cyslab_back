<?php

namespace App\DataTables;

use App\Models\Credential;

/**
 * Class CredentialDataTable
 */
class CredentialDataTable
{
    /**
     * @return Credential
     */
    public function get()
    {
        /** @var Credential $query */
        $query = Credential::query()->select('credentials.*');

        return $query;
    }
}
