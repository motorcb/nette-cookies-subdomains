<?php

namespace App\Model;

use App;
use Nette;
use Nette\Security;

/**
 * Users authenticator.
 */
class Authenticator extends Nette\Object implements Nette\Security\IAuthenticator
{

    /**
     * Performs an authentication.
     * @return Nette\Security\Identity
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate( array $credentials )
    {
        list($email, $password) = $credentials;

        $data = array("first" => "Jmeno", "last" => "Prijmeni");

        return new Security\Identity( 111, NULL, $data );
    }

}
