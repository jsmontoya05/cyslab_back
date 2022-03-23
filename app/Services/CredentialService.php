<?php

namespace App\Services;

use App\Models\Credential;


class CredentialService
{
    /**
     * Obtain one single credential from the credential service
     * @return string
     */
    public function getCredential()
    {
        return Credential::where('active',1)->first();
    }

}


