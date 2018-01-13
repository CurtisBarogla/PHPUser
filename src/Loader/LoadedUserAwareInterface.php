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

/**
 * Make a component aware of a user loaded from a user loader
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
interface LoadedUserAwareInterface
{
    
    /**
     * Link the loaded user to the component
     * 
     * @param AuthenticationUserInterface $user
     *   User loaded
     */
    public function setUser(AuthenticationUserInterface $user): void;
    
    /**
     * Get the user linked to the component
     * 
     * @return AuthenticationUserInterface
     *   User loaded linked
     */
    public function getUser(): AuthenticationUserInterface;
    
}
