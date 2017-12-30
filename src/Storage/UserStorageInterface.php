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

use Zoe\Component\User\AuthenticatedUserInterface;
use Zoe\Component\User\Exception\UserNotFoundException;
use Zoe\Component\User\UserInterface;

/**
 * Responsible to store user
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
interface UserStorageInterface
{
    
    /**
     * Prefix for user identifier
     * MUST be setted at the very beginning of each user identifier on every implementation 
     * 
     * @var string
     */
    public const BASE_USER_ID = "USER_STORED_ID";
    
    /**
     * Add a user into the store
     * 
     * @param UserInterface $user
     *   User to add
     * @param string|null $identifier
     *   Unique user identifier
     */
    public function add(UserInterface $user, ?string $identifier = null): void;
    
    /**
     * Refresh an already store user
     * 
     * @param UserInterface $user
     *   Refreshed user
     * @param string|null $identifier
     *   User identifier to refresh
     *   
     * @throws UserNotFoundException
     *   When this user does no exist for this identifier
     */
    public function refresh(UserInterface $user, ?string $identifier = null): void;
    
    /**
     * Get an already stored user
     * 
     * @param string $identifier
     *   User identifier
     *   
     * @return AuthenticatedUserInterface
     *   User referred to the identifier
     */
    public function get(?string $identifier = null): UserInterface;
    
    /**
     * Delete a user by his identifier
     * 
     * @param string|null $identifier
     *   User identifier to delete
     *   
     * @throws UserNotFoundException
     *   When this identifier does not refer a user
     */
    public function delete(?string $identifier = null): void;
    
    /**
     * Check if a user is store by its identifier
     * 
     * @param string|null $identifier
     *   User identifier
     * 
     * @return bool
     *   True if a user exists for this identifier. False otherwise
     */
    public function has(?string $identifier = null): bool;
    
}
