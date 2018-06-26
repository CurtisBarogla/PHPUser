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
use Ness\Component\User\Exception\UserAttributeNotFoundException;

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
        $user = new User("Foo");
        
        $user->addAttribute("Foo", "Bar");
        $user->addAttribute("Bar", null);
        
        $this->assertSame("Bar", $user->getAttribute("Foo"));
        $this->assertNull($user->getAttribute("Bar"));
    }
    
    /**
     * @see \Ness\Component\User\User::deleteAttribute()
     */
    public function testDeleteAttribute(): void
    {
        $user = new User("Foo");
        
        $user->addAttribute("Foo", "Bar");
        $user->addAttribute("Bar", null);
        
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
     * @see \Ness\Component\User\User::getAttribute()
     */
    public function testExceptionGetAttributeWhenNoAttribute(): void
    {
        $this->expectException(UserAttributeNotFoundException::class);
        $this->expectExceptionMessage("This attribute 'Foo' is not setted into user 'FooUser'");
        
        $user = new User("FooUser");
        
        $user->getAttribute("Foo");
    }
    
    /**
     * @see \Ness\Component\User\User::deleteAttribute()
     */
    public function testExceptionDeleteAttributeWhenNoAttribute(): void
    {
        $this->expectException(UserAttributeNotFoundException::class);
        $this->expectExceptionMessage("This attribute 'Foo' is not setted into user 'FooUser'");
        
        $user = new User("FooUser");
        
        $user->deleteAttribute("Foo");
    }
    
}
