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

namespace Ness\Component\User\Role;

use Ness\Component\User\Traits\UserAwareTrait;
use Ness\Component\User\Exception\UndefinedRoleException;

/**
 * Native implementation of RoleHierarchyUserInteraction
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class RoleHierarchyUserInteraction extends RoleHierarchy implements RoleHierarchyUserInteractionInterface
{
    
    use UserAwareTrait;
    
    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\Role\RoleHierarchyUserInteractionInterface::userHasRole()
     */
    public function userHasRole(string $role): bool
    {
        $user = $this->getUser();
        
        if($user->hasRole($role))
            return true;
        
        if (null === $userRoles = $user->getRoles())
            return false;
        
        foreach ($userRoles as $userRole) {
            try {
                if(\in_array($role, $this->getRoles($userRole)))
                    return true;                
            } catch (UndefinedRoleException $e) {
                continue;
            }
        }
        
        return false;
    }

}
