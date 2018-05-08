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

namespace Ness\Component\User;

/**
 * Make a component aware of a user to work with
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
interface UserAwareInterface
{
    
    /**
     * Get linked user
     * 
     * @return UserInterface
     *   User linked
     */
    public function getUser(): UserInterface;
    
    /**
     * Link a user to the component
     * 
     * @param UserInterface $user
     *   User to link
     */
    public function setUser(UserInterface $user): void;
    
}
