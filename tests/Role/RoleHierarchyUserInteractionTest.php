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
use Ness\Component\User\Role\RoleHierarchyUserInteraction;
use Ness\Component\User\UserInterface;

/**
 * RoleHierarchyUserInteraction testcase
 * 
 * @see \Ness\Component\User\Role\RoleHierarchyUserInteraction
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class RoleHierarchyUserInteractionTest extends UserTestCase
{
    
    /**
     * @see \Ness\Component\User\Role\RoleHierarchyUserInteraction::userHasRole()
     * @see \Ness\Component\User\Role\RoleHierarchyUserInteraction::setUser()
     * @see \Ness\Component\User\Role\RoleHierarchyUserInteraction::getUser()
     */
    public function testUserHasRole(): void
    {
        $hierarchy = new RoleHierarchyUserInteraction();
        
        $hierarchy->addRole("Foo");
        $hierarchy->addRole("Bar");
        $hierarchy->addRole("Moz", ["Foo"]);
        $hierarchy->addRole("Loz", ["Moz"]);
        
        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        $user->expects($this->exactly(3))->method("getRoles")->will($this->onConsecutiveCalls(["Moz", "Poz"], ["Moz", "Poz"], null));
        $user
            ->expects($this->exactly(4))
            ->method("hasRole")
            ->withConsecutive(["Foo"], ["Loz"], ["Foo"], ["Kek"])
            ->will($this->onConsecutiveCalls(false, false, false, true));
        
        $this->assertNull($hierarchy->setUser($user));
        $this->assertSame($user, $hierarchy->getUser());
        
        $this->assertTrue($hierarchy->userHasRole("Foo"));
        $this->assertFalse($hierarchy->userHasRole("Loz"));
        $this->assertFalse($hierarchy->userHasRole("Foo"));
        $this->assertTrue($hierarchy->userHasRole("Kek"));
    }
    
}
