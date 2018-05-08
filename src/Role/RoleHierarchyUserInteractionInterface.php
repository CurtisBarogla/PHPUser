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

use Ness\Component\User\UserAwareInterface;
use Ness\Component\User\Exception\UndefinedRoleException;

/**
 * Extended version of the RoleHierarchy to interact with an user
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
interface RoleHierarchyUserInteractionInterface extends RoleHierarchyInterface, UserAwareInterface
{
    
    /**
     * Check if an user has the given role depending of a defined role hierarchy
     * 
     * @param string $role
     *   Role to check
     * 
     * @return bool
     *   True if the user has the given role depending of the defined role hierarchy
     *   
     * @throws UndefinedRoleException
     *   When given role cannot be resolved into the role hierarchy
     */
    public function userHasRole(string $role): bool;
    
}
