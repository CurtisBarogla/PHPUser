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

namespace NessTest\Component\User\Role;

use NessTest\Component\User\UserTestCase;
use Ness\Component\User\Role\RoleHierarchy;
use Ness\Component\User\Exception\UndefinedRoleException;

/**
 * RoleHierarchy testcase
 * 
 * @see \Ness\Component\User\Role\RoleHierarchy
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class RoleHierarchyTest extends UserTestCase
{
    
    /**
     * @see \Ness\Component\User\Role\RoleHierarchy::getRoles()
     */
    public function testGetRoles(): void
    {
        $hierarchy = new RoleHierarchy();
        
        $hierarchy->addRole("Foo");
        $hierarchy->addRole("Bar", ["Foo"]);
        $hierarchy->addRole("Moz", ["Bar", "Foo"]);
        
        $this->assertSame(["Foo"], $hierarchy->getRoles("Foo"));
        $this->assertSame(["Moz", "Bar", "Foo"], $hierarchy->getRoles("Moz"));
    }
    
    /**
     * @see \Ness\Component\User\Role\RoleHierarchy::addRole()
     */
    public function testAddRole(): void
    {
        $hierarchy = new RoleHierarchy();
        
        $this->assertNull($hierarchy->addRole("Foo"));
        $this->assertNull($hierarchy->addRole("Bar", ["Foo"]));
    }
    
                    /**_____EXCEPTIONS_____**/
    
    /**
     * @see \Ness\Component\User\Role\RoleHierarchy::getRoles()
     */
    public function testExceptionGetRolesWhenRoleNotSetted(): void
    {
        $this->expectException(UndefinedRoleException::class);
        $this->expectExceptionMessage("This role 'Foo' is not registered into RoleHierarchy");
        
        $hierarchy = new RoleHierarchy();  
        
        $hierarchy->getRoles("Foo");
    }
    
    /**
     * @see \Ness\Component\User\Role\RoleHierarchy::addRole()
     */
    public function testExceptionAddRoleWhenAParentRoleIsNotSetted(): void
    {
        $this->expectException(UndefinedRoleException::class);
        $this->expectExceptionMessage("This role 'Foo' is not registered into RoleHierarchy");
        
        $hierarchy = new RoleHierarchy();
        
        $hierarchy->addRole("Bar", ["Foo"]);
    }
    
}
