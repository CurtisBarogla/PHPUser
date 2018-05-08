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
 * Interacts with an external storage component to handle user storage process.
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
interface UserStorageInterface
{
    
    /**
     * Get an already stored user.
     * 
     * @return UserInterface|null
     *   User stored or null if no user has been found
     */
    public function get(): ?UserInterface;
    
    /**
     * Store an user
     * 
     * @param UserInterface $user
     *   User to store
     *   
     * @return bool
     *   True if the user has been correctly stored. False otherwise
     */
    public function store(UserInterface $user): bool;
    
    /**
     * Refresh an already stored user
     * 
     * @param UserInterface $user
     *   Refreshed user
     * 
     * @return bool
     *   True if user has been refreshed correctly. False otherwise
     */
    public function refresh(UserInterface $user): bool;
    
    /**
     * Delete a stored user
     * 
     * @return bool
     *   True if the user has been correctly deleted from the store. False otherwise
     */
    public function delete(): bool;
    
}
