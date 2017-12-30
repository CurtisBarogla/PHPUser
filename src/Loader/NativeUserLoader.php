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
use Zoe\Component\User\AuthenticationUser;

/**
 * Load user from an array source
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class NativeUserLoader implements UserLoaderInterface
{
    
    /**
     * Array of users
     * 
     * @var array
     */
    private $users;
    
    /**
     * Initialize loader
     * 
     * @param array $users
     *   Array of users
     */
    public function __construct(array $users)
    {
        $this->users = $users;
    }
    
    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\Loader\UserLoaderInterface::load()
     */
    public function load(AuthenticationUserInterface $user): AuthenticationUserInterface
    {
        $name = $user->getName();
        if(!isset($this->users[$name]))
            throw new UserNotFoundException(\sprintf("This user '%s' cannot be loaded as it cannot be found into the given array",
                $name));
            
        $infos = $this->users[$name];
        
        return new AuthenticationUser(
            $name,
            $infos["password"] ?? null,
            $infos["root"] ?? false,
            $infos["attributes"] ?? null,
            $infos["roles"] ?? null,
            $infos["credentials"] ?? null
        );
    }

}
