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

namespace Zoe\Component\User\Role;

use Zoe\Component\User\Exception\InvalidRoleException;

/**
 * Collection of roles
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class RoleCollection
{
    
    /**
     * Main roles
     * 
     * @var array
     */
    private $roles;
    
    /**
     * Parents roles for each main role
     * 
     * @var array
     */
    private $parents;
    
    /**
     * Add a role into the collection
     * 
     * @param string $role
     *   Role to add
     * @param array|null $parents
     *   Parents roles or null   
     */
    public function add(string $role, ?array $parents = null)
    {
        if(isset($this->roles[$role]))
            throw new InvalidRoleException(\sprintf("This role '%s' is already registered into the collection",
                $role));
            
        $this->roles[$role] = $role;
        
        if(null !== $parents) {
            foreach ($parents as $parent) {
                if(!isset($this->roles[$parent]))
                    throw new InvalidRoleException(\sprintf("This parent role '%s' for role '%s' cannot be setted as not defined into the collection",
                        $parent,
                        $role));
                    
                $this->parents[$role][] = $parent;
                if(!isset($this->parents[$parent]))
                    continue;
                
                foreach ($this->parents[$parent] as $parentRoleParent) {
                    $this->parents[$role][] = $parentRoleParent;   
                }
            }
            
            $this->parents[$role] = \array_unique($this->parents[$role]);
        }
    }
    
    /**
     * Return a role from the collection.
     * Will return the parent one if defined
     * 
     * @param string $role
     *   Role to get
     * 
     * @return array
     *   Role with all its parents if defined
     *   
     * @throws InvalidRoleException
     *   If the role is not registered
     */
    public function get(string $role): array
    {
        if(!isset($this->roles[$role]))
            throw new InvalidRoleException(\sprintf("This role '%s' is not registered into the collection",
                $role));
            
        $roles = [$this->roles[$role]];
        if(isset($this->parents[$role]))
            $roles = \array_merge($roles, $this->parents[$role]);
        
        return $roles;
    }
    
}
