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

use Ness\Component\User\Exception\UndefinedRoleException;

/**
 * Represent a hierarchy of roles
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
interface RoleHierarchyInterface
{
    
    /**
     * Return hierarchy associated to a role
     * 
     * @param string $role
     *   Role which the hierarchy must be get
     * 
     * @return array
     *   A list of role, included asked one, defining hierarchy associated to it
     *   
     * @throws UndefinedRoleException
     *   When given role is not setted into the hierarchy
     */
    public function getRoles(string $role): array;
    
}
