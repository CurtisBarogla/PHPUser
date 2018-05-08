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
use Ness\Component\User\User;

/**
 * Try to load an user from a set of array defining users
 * 
 * Each array MUST define a user respecting given format : 
 * All values prefixed by ? can be null
 * <pre>
 * "username"   =>  ?[
 *      "?attributes"   =>  [all attributes indexed]
 *      "?roles"        =>  [all roles attributed to this user]
 * ]
 * </pre>
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class ArrayPhpFileUserLoader implements UserLoaderInterface
{
    
    /**
     * Containing all users
     * 
     * @var array
     */
    private $definitions = [];
    
    /**
     * Initialize loader
     * 
     * @param array[array] $definitions
     *   A set of arrays defining all loadables users
     */
    public function __construct(array $definitions)
    {
        foreach ($definitions as $definition)
            $this->definitions = \array_merge($this->definitions, $definition);
    }
    
    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\Loader\UserLoaderInterface::loadUser()
     */
    public function loadUser(string $name): UserInterface
    {
        if(!\array_key_exists($name, $this->definitions))
            throw new UserNotFoundException("This user '{$name}' has been not found into ArrayPhpFileLoader");
        
        return new User($name, $this->definitions[$name]["attributes"] ?? null, $this->definitions[$name]["roles"] ?? null);
    }
    
}
