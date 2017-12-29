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
use Zoe\Component\User\AuthenticationUser;
use Zoe\Component\User\Exception\InvalidUserCredentialException;

/**
 * AuthenticationUser testcase
 * 
 * @see \Zoe\Component\User\AuthenticationUser
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class AuthenticationUserTest extends TestCase
{
    
    /**
     * @see \Zoe\Component\User\AuthenticationUser::getPassword()
     * @see \Zoe\Component\User\AuthenticationUser::getCredentials()
     */
    public function testInitialize(): void
    {
        $user = new AuthenticationUser("Foo");
        
        $this->assertSame("Foo", $user->getName());
        $this->assertFalse($user->isRoot());
        $this->assertNull($user->getAttributes());
        $this->assertNull($user->getPassword());
        $this->assertSame(["USER_PASSWORD" => null], $user->getCredentials());
    }
    
    /**
     * @see \Zoe\Component\User\AuthenticationUser::getPassword()
     */
    public function testGetPassword(): void
    {
        $user = new AuthenticationUser("Foo", "Foo");
        
        $this->assertSame("Foo", $user->getPassword());
    }
    
    /**
     * @see \Zoe\Component\User\AuthenticationUser::addCredential()
     */
    public function testAddCredential(): void
    {
        $user = new AuthenticationUser("Foo");
        
        $this->assertNull($user->addCredential("Foo", "Bar"));
        $this->assertSame("Bar", $user->getCredential("Foo"));
    }
    
    /**
     * @see \Zoe\Component\User\AuthenticationUser::getCredentials()
     */
    public function testGetCredentials(): void
    {
        $user = new AuthenticationUser("Foo", null, false, null, null, ["Foo" => "Bar"]);
        
        $this->assertSame(["Foo" => "Bar", "USER_PASSWORD" => null], $user->getCredentials());
    }
    
    /**
     * @see \Zoe\Component\User\AuthenticationUser::getCredential()
     */
    public function testGetCredential(): void
    {
        $user = new AuthenticationUser("Foo", null, false, null, null, ["Foo" => "Bar"]);
        
        $this->assertNull($user->getCredential("USER_PASSWORD"));
        $this->assertSame("Bar", $user->getCredential("Foo"));
    }
    
                    /**_____EXCEPTIONS_____**/
    
    /**
     * @see \Zoe\Component\User\AuthenticationUser::getCredential()
     */
    public function testExceptionGetCredentialOnInvalidCredential(): void
    {
        $this->expectException(InvalidUserCredentialException::class);
        $this->expectExceptionMessage("This credential 'Foo' for user 'Bar' is invalid");
        
        $user = new AuthenticationUser("Bar");
        $user->getCredential("Foo");
    }
    
}
