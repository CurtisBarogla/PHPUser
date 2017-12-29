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
use Zoe\Component\User\AuthenticatedUser;

/**
 * AuthenticatedUser testcase
 * 
 * @see \Zoe\Component\User\AuthenticatedUser
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class AuthenticatedUserTest extends TestCase
{
    
    /**
     * @see \Zoe\Component\User\AuthenticatedUser::authenticatedAt()
     */
    public function testInitialize(): void
    {
        $user = new AuthenticatedUser("Foo", new \DateTime());
        
        $this->assertSame("Foo", $user->getName());
        $this->assertFalse($user->isRoot());
        $this->assertNull($user->getAttributes());
        $this->assertNull($user->getRoles());
        $this->assertInstanceOf(\DateTimeInterface::class, $user->authenticatedAt());
    }
    
    /**
     * @see \Zoe\Component\User\AuthenticatedUser::authenticatedAt()
     */
    public function testAuthenticatedAt(): void
    {
        $time = new \DateTime();
        $user = new AuthenticatedUser("Foo", $time);
        
        $this->assertSame($time, $user->authenticatedAt());
    }
    
    /**
     * @see \Zoe\Component\User\AuthenticatedUser::jsonSerialize()
     */
    public function testJsonSerialize(): void
    {
        $user = new AuthenticatedUser("Foo", new \DateTime(), false, ["Foo" => "Bar"], ["Foo", "Bar"]);
        
        $this->assertNotFalse(\json_encode($user));
    }
    
    /**
     * @see \Zoe\Component\User\AuthenticatedUser::restore()
     */
    public function testRestore(): void
    {
        $time = \DateTime::createFromFormat("U", (string) \time());
        $user = new AuthenticatedUser("Foo", $time, false, ["Foo" => "Bar"], ["Foo", "Bar"]);
        
        $json = \json_encode($user);
        
        $this->assertEquals($user, AuthenticatedUser::restore($json));
        
        $json = \json_decode($json, true);
        
        $this->assertEquals($user, AuthenticatedUser::restore($json));
    }
    
}
