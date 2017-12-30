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

namespace ZoeTest\Component\User\Loader;

use PHPUnit\Framework\TestCase;
use Zoe\Component\User\AuthenticationUserInterface;
use Zoe\Component\User\Loader\NativeUserLoader;
use Zoe\Component\User\Exception\UserNotFoundException;

/**
 * NativeUserLoader testcase
 * 
 * @see \Zoe\Component\User\Loader\NativeUserLoader
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class NativeUserLoaderTest extends TestCase
{
    
    /**
     * @see \Zoe\Component\User\Loader\NativeUserLoader::load()
     */
    public function testLoad(): void
    {
        $users = [
            "Foo"       =>  [
                
            ],
            "Bar"       =>  [
                "password"      =>  "Foo",
                "root"          =>  true,
                "attributes"    =>  [
                    "Foo"           =>  "Bar",
                    "Bar"           =>  "Foo"
                ],
                "roles"         =>  ["Foo", "Bar"],
                "credentials"   =>  ["Foo" => "Bar"]
            ]
        ];
        
        $loader = new NativeUserLoader($users);
        
        // make sure that no information are leaked into the loaded one
        $mockFooUser = $this->getMockBuilder(AuthenticationUserInterface::class)->getMock();
        $mockFooUser->expects($this->once())->method("getName")->will($this->returnValue("Foo"));
        $mockFooUser->expects($this->never())->method("getRoles");
        $mockFooUser->expects($this->never())->method("getCredentials");
        $mockFooUser->expects($this->never())->method("getAttributes");
        $mockFooUser->expects($this->never())->method("isRoot");
        $mockFooUser->expects($this->never())->method("getPassword");
        $mockFooUser->expects($this->never())->method("getAttribute");
        
        $mockBarUser = $this->getMockBuilder(AuthenticationUserInterface::class)->getMock();
        $mockBarUser->expects($this->once())->method("getName")->will($this->returnValue("Bar"));
        
        $fooUser = $loader->load($mockFooUser);
        $barUser = $loader->load($mockBarUser);
        
        $this->assertSame("Foo", $fooUser->getName());
        $this->assertNull($fooUser->getPassword());
        $this->assertNull($fooUser->getAttributes());
        $this->assertNull($fooUser->getRoles());
        $this->assertFalse($fooUser->isRoot());
        $this->assertSame(["USER_PASSWORD" => null], $fooUser->getCredentials());
        
        $this->assertSame("Bar", $barUser->getName());
        $this->assertSame("Foo", $barUser->getPassword());
        $this->assertSame(["Foo" => "Bar", "Bar" => "Foo"], $barUser->getAttributes());
        $this->assertSame(["Foo" => "Foo", "Bar" => "Bar"], $barUser->getRoles());
        $this->assertTrue($barUser->isRoot());
        $this->assertSame(["Foo" => "Bar", "USER_PASSWORD" => "Foo"], $barUser->getCredentials());
    }
    
                    /**_____EXCEPTIONS_____**/

    /**
     * @see \Zoe\Component\User\Loader\NativeUserLoader::load()
     */
    public function testExceptionLoadUserWhenNotUserIsFound(): void
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage("This user 'Foo' cannot be loaded as it cannot be found into the given array");
        
        $users = [];
        
        $loader = new NativeUserLoader($users);
        
        $user = $this->getMockBuilder(AuthenticationUserInterface::class)->getMock();
        $user->expects($this->once())->method("getName")->will($this->returnValue("Foo"));
        
        $loader->load($user);
    }
    
}
