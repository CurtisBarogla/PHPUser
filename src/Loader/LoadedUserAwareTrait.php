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
 * Shortcut to make a component aware of a loaded user
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
trait LoadedUserAwareTrait
{
    
    /**
     * User from a user loaded
     * 
     * @var AuthenticationUserInterface
     */
    protected $user;
    
    /**
     * Link the loaded user to the component
     *
     * @param AuthenticationUserInterface $user
     *   User loaded
     */
    public function setUser(AuthenticationUserInterface $user): void
    {
        $this->user = $user;
    }
    
    /**
     * Get the user linked to the component
     *
     * @return AuthenticationUserInterface
     *   User loaded linked
     */
    public function getUser(): AuthenticationUserInterface
    {
        return $this->user;
    }
    
}
