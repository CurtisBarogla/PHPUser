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

namespace ZoeTest\Component\User;

use PHPUnit\Framework\TestCase;
use ZoeTest\Component\User\Fixture\FooUser;
use Zoe\Component\User\Exception\InvalidUserAttributeException;

/**
 * User testcase
 * 
 * @see \Zoe\Component\User\User
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class UserTest extends TestCase
{
    
    /**
     * @see \Zoe\Component\User\User::__construct()
     * @see \Zoe\Component\User\User::isRoot()
     * @see \Zoe\Component\User\User::getAttributes()
     * @see \Zoe\Component\User\User::getRoles()
     * @see \Zoe\Component\User\User::hasAttribute()
     * @see \Zoe\Component\User\User::hasRole()
     */
    public function testInitialize(): void
    {
        $user = new FooUser("Foo");
        
        $this->assertSame("Foo", $user->getName());
        $this->assertFalse($user->isRoot());
        $this->assertNull($user->getAttributes());
        $this->assertNull($user->getRoles());
        $this->assertFalse($user->hasAttribute("Foo"));
        $this->assertFalse($user->hasRole("Foo"));
    }
    
    /**
     * @see \Zoe\Component\User\User::getName()
     */
    public function testGetName(): void
    {
        $user = new FooUser("Foo");
        
        $this->assertSame("Foo", $user->getName());
    }
    
    /**
     * @see \Zoe\Component\User\User::isRoot()
     */
    public function testIsRoot(): void
    {
        $user = new FooUser("Foo");
        
        $this->assertFalse($user->isRoot());
        
        $user = new FooUser("Foo", true);
        
        $this->assertTrue($user->isRoot());
    }
    
    /**
     * @see \Zoe\Component\User\User::addAttribute()
     */
    public function testAddAttribute(): void
    {
        $user = new FooUser("Foo");
        
        $this->assertNull($user->addAttribute("Foo", "Bar"));
    }
    
    /**
     * @see \Zoe\Component\User\User::getAttributes()
     */
    public function testGetAttributes(): void
    {
        $user = new FooUser("Foo", false);
        
        $this->assertNull($user->getAttributes());
        
        $user = new FooUser("Foo", false, ["Foo" => "Bar", "Bar" => "Foo"]);
        
        $this->assertSame(["Foo" => "Bar", "Bar" => "Foo"], $user->getAttributes());
    }
    
    /**
     * @see \Zoe\Component\User\User::getAttribute()
     */
    public function testGetAttribute(): void
    {
        $user = new FooUser("Foo", false, ["Foo" => "Bar"]);

        $this->assertSame("Bar", $user->getAttribute("Foo"));
    }
    
    /**
     * @see \Zoe\Component\User\User::hasAttribute()
     */
    public function testHasAttribute(): void
    {
        $user = new FooUser("Foo", false, ["Foo" => "Bar", "Bar" => null]);
        
        $this->assertTrue($user->hasAttribute("Foo"));
        $this->assertTrue($user->hasAttribute("Bar"));
        $this->assertFalse($user->hasAttribute("Moz"));
    }
    
    /**
     * @see \Zoe\Component\User\User::getRoles()
     */
    public function testGetRoles(): void
    {
        $user = new FooUser("Foo");
        
        $this->assertNull($user->getRoles());
        
        $user = new FooUser("Foo", false, null, ["Foo", "Bar"]);
        
        $this->assertSame(["Foo" => "Foo", "Bar" => "Bar"], $user->getRoles());
    }
    
    /**
     * @see \Zoe\Component\User\User::hasRole()
     */
    public function testHasRole(): void
    {
        $user = new FooUser("Foo", false, null, ["Foo"]);
        
        $this->assertTrue($user->hasRole("Foo"));
        $this->assertFalse($user->hasRole("Bar"));
    }
    
                    /**_____EXCEPTIONS_____**/
    
    /**
     * @see \Zoe\Component\User\User::getAttribute()
     */
    public function testExceptionGetAttributeOnInvalidAttribute(): void
    {
        $this->expectException(InvalidUserAttributeException::class);
        $this->expectExceptionMessage("This attribute 'Foo' for user 'Bar' is invalid");
        
        $user = new FooUser("Bar");
        $user->getAttribute("Foo");
    }
    
}
