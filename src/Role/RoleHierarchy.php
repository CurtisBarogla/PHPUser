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
 * Native implementation of RoleHierarchy
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class RoleHierarchy implements RoleHierarchyInterface
{
    
    /**
     * Main roles registered
     * 
     * @var array
     */
    protected $roles = [];
    
    /**
     * Map reprensenting hierarchy for each main role
     * 
     * @var array
     */
    protected $map = [];
    
    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\Role\RoleHierarchyInterface::getRoles()
     */
    public function getRoles(string $role): array
    {
        if(!\in_array($role, $this->roles))
            throw new UndefinedRoleException("This role '{$role}' is not registered into RoleHierarchy");
        
        return isset($this->map[$role]) ? \array_merge([], [$role], $this->map[$role]) : [$role];
    }
    
    /**
     * Add a role into the hierarchy
     * 
     * @param string $role
     *   Role to add
     * @param array|null $parents
     *   Parents for this role. Leave to null if none
     *   
     * @throws UndefinedRoleException
     *   When a parent role cannot be resolved
     */
    public function addRole(string $role, ?array $parents = null): void
    {
        $this->roles[] = $role;
        
        if(null !== $parents) {
            $map = [];
            foreach ($parents as $parent) {
                $map[] = $parent;
                $map = \array_merge($map, $this->getRoles($parent));
            }
            unset($map[0]);
            
            $this->map[$role] = \array_values(\array_unique($map));
        }
    }
    
}
