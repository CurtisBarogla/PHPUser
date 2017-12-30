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

namespace Zoe\Component\User\Storage;

use Zoe\Component\User\UserInterface;
use Zoe\Component\User\Exception\UserNotFoundException;

/**
 * Use native session superglobal to store user.
 * Session MUST be active
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class NativeSessionStorage implements UserStorageInterface
{   
    
    /**
     * Reference to $_SESSION
     * 
     * @var array
     */
    private $session;
    
    /**
     * If SID must be refreshed after a user is added or refreshed
     * 
     * @var bool
     */
    private $refresh;
    
    /**
     * Initialize store
     * 
     * @param bool $refresh
     *   Set to true to refresh SID after a user is added or refreshed
     */
    public function __construct(bool $refresh = false)
    {
        $this->session = &$_SESSION;
    }
    
    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\Storage\UserStorageInterface::add()
     */
    public function add(UserInterface $user, ?string $identifier = null): void
    {
        if($this->refresh)
            \session_regenerate_id();
        
        $this->session[self::BASE_USER_ID.$identifier] = $user;
    }
    
    /** 
     * {@inheritDoc}
     * @see \Zoe\Component\User\Storage\UserStorageInterface::refresh()
     */
    public function refresh(UserInterface $user, ?string $identifier = null): void
    {
        $this->checkUser($identifier);
            
        unset($this->session[self::BASE_USER_ID.$identifier]);
        $this->add($user, $identifier);
    }

    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\Storage\UserStorageInterface::get()
     */
    public function get(?string $identifier = null): UserInterface
    {
        $this->checkUser($identifier);
        
        return $this->session[self::BASE_USER_ID.$identifier];
    }

    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\Storage\UserStorageInterface::delete()
     */
    public function delete(?string $identifier = null): void
    {
        $this->checkUser($identifier);
        
        unset($this->session[self::BASE_USER_ID.$identifier]);
    }
    
    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\Storage\UserStorageInterface::has()
     */
    public function has(?string $identifier = null): bool
    {
        return isset($this->session[self::BASE_USER_ID.$identifier]);
    }
    
    /**
     * Check if an identifier exists into the store
     * 
     * @param string|null $identifier
     *   Identifier to check
     * 
     * @throws UserNotFoundException
     *   If no user has been found stored
     */
    private function checkUser(?string $identifier): void
    {
        if(!$this->has($identifier))
            throw new UserNotFoundException(\sprintf("No user for this identifier '%s' has been found stored",
                self::BASE_USER_ID.$identifier));
    }

}
