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
 * Try to load an user from multiple registered user loader
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class UserLoaderCollection implements UserLoaderInterface
{
    
    /**
     * Registered loaders
     * 
     * @var UserLoaderInterface[]
     */
    private $loaders;
    
    /**
     * Initialize loader
     * 
     * @param UserLoaderInterface $defaultLoader
     *   Default loader
     */
    public function __construct(UserLoaderInterface $defaultLoader)
    {
        $this->loaders[] = $defaultLoader;
    }
    
    /**
     * Register a loader into the collection
     * 
     * @param UserLoaderInterface $loader
     *   User loader
     */
    public function addLoader(UserLoaderInterface $loader): void
    {
        $this->loaders[] = $loader;
    }
    
    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\Loader\UserLoaderInterface::loadUser()
     */
    public function loadUser(string $name): UserInterface
    {
        foreach ($this->loaders as $loader) {
            try {
                return $loader->loadUser($name);
            } catch (UserNotFoundException $e) {
                continue;
            }
        }
        
        throw new UserNotFoundException("This user '{$name}' cannot be loaded over registered loaders into UserLoaderCollection");
    }

}
