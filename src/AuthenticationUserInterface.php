<?php
//StrictType
declare(strict_types = 1);

/*
 * Zoe
 * User component
 *
 * Author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */

namespace Zoe\Component\User;

use Zoe\Component\User\Exception\InvalidUserCredentialException;

/**
 * Hold credentials needed for authentication
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
interface AuthenticationUserInterface extends UserInterface
{
    
    /**
     * Get user password.
     * Can be null
     * 
     * @return string|null
     *   User password or null
     */
    public function getPassword(): ?string;
    
    /**
     * Get all users credentials or null if no credential has been setted
     * 
     * @return iterable|null
     *   All credentials or null
     */
    public function getCredentials(): ?iterable;
    
    /**
     * Get a user credential
     * 
     * @param string $credential
     *   Credential name
     *  
     * @return mixed
     *   Credential value
     *   
     * @throws InvalidUserCredentialException
     *   When the given credential is invalid
     */
    public function getCredential(string $credential);
    
}
