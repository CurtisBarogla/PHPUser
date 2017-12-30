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
 * Loads user from various loaders
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class UserLoaderCollection implements UserLoaderInterface
{
    
    /**
     * Registered loaders
     * 
     * @var UserLoaderInterface
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
     * Add a loader to the collection
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
     * @see \Zoe\Component\User\Loader\UserLoaderInterface::load()
     */
    public function load(AuthenticationUserInterface $user): AuthenticationUserInterface
    {
        foreach ($this->loaders as $loader) {
            try {
                return $loader->load($user); 
            } catch (UserNotFoundException $e) {
                continue;
            }
        }
        
        throw new UserNotFoundException(\sprintf("This user '%s' cannot be loaded via all registered loaders", 
            $user->getName()));
    }
    
}
