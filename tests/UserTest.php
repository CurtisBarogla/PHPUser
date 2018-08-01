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

use NessTest\Component\User\UserTestCase;
use Ness\Component\User\Exception\InvalidUserAttributeException;
use Ness\Component\User\Exception\InvalidUserAttributeValueException;

/**
 * User testcase
 * 
 * @see \Ness\Component\User\User
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class UserTest extends UserTestCase
{
    
    /**
     * @see \Ness\Component\User\User::getName()
     */
    public function testGetName(): void
    {
        $user = new User("Foo");
        
        $this->assertSame("Foo", $user->getName());
    }
    
    /**
     * @see \Ness\Component\User\User::addAttribute()
     */
    public function testAddAttribute(): void
    {
        $user = new User("Foo");
        
        $this->assertSame($user, $user->addAttribute("Foo", "Bar"));
        $this->assertSame($user, $user->addAttribute("Bar", null));
    }
    
    /**
     * @see \Ness\Component\User\User::getAttributes()
     */
    public function testGetAttributes(): void
    {
        $user = new User("Foo");
        
        $this->assertNull($user->getAttributes());
        
        $user->addAttribute("Foo", "Bar");
        
        $this->assertSame(["Foo" => "Bar"], $user->getAttributes());
    }
    
    /**
     * @see \Ness\Component\User\User::getAttribute()
     */
    public function testGetAttribute(): void
    {
        $user = new User("Foo", ["Moz" => "Poz"]);
        
        $user->addAttribute("Foo", "Bar");
        $user->addAttribute("Loz", null);
        
        $this->assertSame("Bar", $user->getAttribute("Foo"));
        $this->assertSame("Poz", $user->getAttribute("Moz"));
        $this->assertNull($user->getAttribute("Loz"));
        $this->assertNull($user->getAttribute("Bar"));
    }
    
    /**
     * @see \Ness\Component\User\User::deleteAttribute()
     */
    public function testDeleteAttribute(): void
    {
        $user = new User("Foo");
        
        $user->addAttribute("Foo", "Bar");
        
        $this->assertNull($user->deleteAttribute("Foo"));
        $this->assertNull($user->deleteAttribute("Bar"));
    }
    
    /**
     * @see \Ness\Component\User\User::getRoles()
     */
    public function testGetRoles(): void
    {
        $user = new User("Foo");
        
        $this->assertNull($user->getRoles());
        
        $user = new User("Foo", null, ["Foo", "Bar"]);
        
        $this->assertSame(["Foo", "Bar"], $user->getRoles());
    }
    
    /**
     * @see \Ness\Component\User\User::hasRole()
     */
    public function testHasRole(): void
    {
        $user = new User("Foo");
        
        $this->assertFalse($user->hasRole("Foo"));
        
        $user = new User("Foo", null, ["Foo", "Bar"]);
        
        $this->assertTrue($user->hasRole("Foo"));
        $this->assertFalse($user->hasRole("Moz"));
    }
    
    /**
     * @see \Ness\Component\User\User::__toString()
     */
    public function test__toString(): void
    {
        $this->expectOutputString("Foo");
        
        $user = new User("Foo");
        
        echo $user;
    }
    
                    /**_____EXCEPTIONS_____**/
    
    /**
     * @see \Ness\Component\User\User::__construct()
     */
    public function testException__constructWhenAnInvalidAttributeNameiIsGiven(): void
    {
        $this->expectException(InvalidUserAttributeException::class);
        $this->expectExceptionMessage("Attribute name 'Foo-' does not respect attribute name convention pattern [a-zA-Z0-9_]");
        
        $user = new User("Foo", ["Bar" => "Foo", "Foo-" => "Bar"]);
    }
    
    /**
     * @see \Ness\Component\User\User::addAttribute()
     */
    public function testExceptionAddAttributeWhenAttributeNameIsInvalid(): void
    {
        $this->expectException(InvalidUserAttributeException::class);
        $this->expectExceptionMessage("Attribute name 'Foo-' does not respect attribute name convention pattern [a-zA-Z0-9_]");
        
        $user = new User("Foo");
        
        $user->addAttribute("Foo-", "Bar");
    }
    
    /**
     * @see \Ness\Component\User\User::addAttribute()
     */
    public function testExceptionAddAttributeWhenAResourceIsGivenAsValue(): void
    {
        $this->expectException(InvalidUserAttributeValueException::class);
        $this->expectExceptionMessage("Cannot store this attribute 'Foo' as its value is invalid");
        
        $user = new User("Foo");
        $resource = \fopen(__FILE__, "r");
        $user->addAttribute("Foo", $resource);
    }
    
    /**
     * @see \Ness\Component\User\User::addAttribute()
     */
    public function testExceptionAddAttributeWhenAClosureIsGivenAsValue(): void
    {
        $this->expectException(InvalidUserAttributeValueException::class);
        $this->expectExceptionMessage("Cannot store this attribute 'Foo' as its value is invalid");
        
        $user = new User("Foo");
        $user->addAttribute("Foo", function(): void {});
    }
    
    /**
     * @see \Ness\Component\User\User::addAttribute()
     */
    public function testExceptionAddAttributeWhenAnAnonymousClassIsGivenAsValue(): void
    {
        $this->expectException(InvalidUserAttributeValueException::class);
        $this->expectExceptionMessage("Cannot store this attribute 'Foo' as its value is invalid");
        
        $user = new User("Foo");
        $resource = \fopen(__FILE__, "r");
        $user->addAttribute("Foo", new class {});
    }
    
}
