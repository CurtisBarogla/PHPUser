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

namespace Ness\Component\User\Storage;

use Ness\Component\User\UserInterface;

/**
 * Simply use $_SESSION to store a user
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class NativeSessionUserStorage implements UserStorageInterface
{
    
    /**
     * Alias to $_SESSION
     * 
     * @var array
     */
    private $session;
    
    /**
     * Set to true to regenerate session_id when user is added or refreshed
     * 
     * @var bool
     */
    private $regenerate;

    /**
     * Identifier to get the user from $_SESSION
     * 
     * @var string
     */
    public const NATIVE_SESSION_USER_IDENTIFIER = "NATIVE_STORAGE_USER";
    
    /**
     * Initialize storage
     * 
     * @param bool $regenerate
     *   Set to true to regenerate session_id when an user is added or refreshed
     * 
     * @throws \LogicException
     *   When session is not started
     */
    public function __construct(bool $regenerate = true)
    {
        if(session_status() !== PHP_SESSION_ACTIVE)
            throw new \LogicException("Session MUST be active to user NativeSessionUserStorage as a storage for users");
        
        $this->session = &$_SESSION;
        $this->regenerate = $regenerate;
    }
    
    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\Storage\UserStorageInterface::get()
     */
    public function get(): ?UserInterface
    {
        return $this->session[self::NATIVE_SESSION_USER_IDENTIFIER] ?? null;
    }
    
    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\Storage\UserStorageInterface::store()
     */
    public function store(UserInterface $user): bool
    {
        if($this->regenerate && !session_regenerate_id())
            return false;
        
        $this->session[self::NATIVE_SESSION_USER_IDENTIFIER] = $user;
        
        return true;
    }
    
    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\Storage\UserStorageInterface::refresh()
     */
    public function refresh(UserInterface $user): bool
    {
        return $this->delete() && $this->store($user);
    }

    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\Storage\UserStorageInterface::delete()
     */
    public function delete(): bool
    {
        if(!isset($this->session[self::NATIVE_SESSION_USER_IDENTIFIER]))
            return false;
        
        unset($this->session[self::NATIVE_SESSION_USER_IDENTIFIER]);
        
        return true;
    }

}
