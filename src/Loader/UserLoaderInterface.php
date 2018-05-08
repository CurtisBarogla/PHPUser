<?php
//StrictType
declare(strict_types = 1);

/*
 * Ness
 * User component
 *
 * Author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */

namespace Ness\Component\User\Loader;

use Ness\Component\User\UserInterface;
use Ness\Component\User\Exception\UserNotFoundException;

/**
 * Try to load an user by its name from externals sources
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
interface UserLoaderInterface
{
    
    /**
     * Load a user by its name.
     * No identification MUST be done during the loading process
     * 
     * @param string $name
     *   User name
     * 
     * @return UserInterface
     *   User with all attributes and roles defined
     *   
     * @throws UserNotFoundException
     *   When no user corresponds
     */
    public function loadUser(string $name): UserInterface;
    
}
