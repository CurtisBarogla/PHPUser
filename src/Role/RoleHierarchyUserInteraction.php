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
     * Will throw an exception if a given user role is not defined into the hierarchy
     * 
     * @var bool
     */
    private $strict;
    
    /**
     * Initialize hierarchy
     * 
     * @param bool $strict
     *   If setted to true, will throw an exception if a user's role is not defined into the hierarchy. 
     *   Else will continue and return false if no role corresponds
     */
    public function __construct(bool $strict = false)
    {
        $this->strict = $strict;
    }
    
    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\Role\RoleHierarchyUserInteractionInterface::userHasRole()
     */
    public function userHasRole(string $role): bool
    {
        $userRoles = $this->getUser()->getRoles();
        
        if (null === $userRoles)
            return false;
        
        foreach ($userRoles as $userRole) {
            try {
                if(\in_array($role, $this->getRoles($userRole)))
                    return true;                
            } catch (UndefinedRoleException $e) {
                if($this->strict)
                    throw new UndefinedRoleException("Role '{$userRole}' defined into user '{$this->getUser()->getName()}' is not setted into role hierarchy");
                
                continue;
            }
        }
        
        return false;
    }

}
