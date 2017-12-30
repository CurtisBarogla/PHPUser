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

namespace Zoe\Component\User\Loader;

use Zoe\Component\User\AuthenticationUserInterface;
use Zoe\Component\User\Exception\UserNotFoundException;

/**
 * Responsible to load user from external sources.
 * Loader is NEVER responsible to check user credentials or other informations about the user
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
interface UserLoaderInterface
{
    
    /**
     * Load a user.
     * Returned user's informations MUST always be setted from a founded one and never from the given one
     * 
     * @param AuthenticationUserInterface $user
     *   User to load
     * 
     * @return AuthenticationUserInterface
     *   Loaded user
     *  
     * @throws UserNotFoundException
     *   When no user has been found
     */
    public function load(AuthenticationUserInterface $user): AuthenticationUserInterface;
    
}
