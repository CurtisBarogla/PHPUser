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

namespace NessTest\Component\User\Loader;

use NessTest\Component\User\UserTestCase;
use Ness\Component\User\Loader\ArrayPhpFileUserLoader;
use Ness\Component\User\UserInterface;
use Ness\Component\User\Exception\UserNotFoundException;

/**
 * ArrayPhpFileUserLoader testcase
 * 
 * @see \Ness\Component\User\Loader\ArrayPhpFileUserLoader
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class ArrayPhpFileUserLoaderTest extends UserTestCase
{
    
    /**
     * @see \Ness\Component\User\Loader\ArrayPhpFileUserLoader::loadUser()
     */
    public function testLoadUser(): void
    {
        $path = __DIR__."/../Fixtures/Loader/ArrayPhpFileLoader";
        
        $loader = new ArrayPhpFileUserLoader([include "{$path}/users1.php", include "{$path}/users2.php"]);
        
        $users = [
            "Foo" => $loader->loadUser("Foo"),
            "Bar" => $loader->loadUser("Bar"),
            "Moz" => $loader->loadUser("Moz"),
            "Poz" => $loader->loadUser("Poz")
        ];
        
        $expected = [
            "Foo"   =>  ["attributes" => null, "roles" => null],
            "Bar"   =>  ["attributes" => ["Foo" => "Bar", "Bar" => "Foo"], "roles" => ["Foo", "Bar"]],
            "Moz"   =>  ["attributes" => null, "roles" => ["Foo", "Bar"]],
            "Poz"   =>  ["attributes" => ["Foo" => "Bar", "Bar" => "Foo"], "roles" => null]
        ];
        
        foreach ($users as $name => $user) {
            $this->assertInstanceOf(UserInterface::class, $user);
            $this->assertSame($expected[$name]["roles"], $user->getRoles());
            if(null !== $attributes = $expected[$name]["attributes"]) {
                foreach ($attributes as $attribute => $value) {
                    $this->assertSame($value, $user->getAttribute($attribute));
                }
            }
        }
    }
    
                    /**_____EXCEPTIONS_____**/
    
    /**
     * @see \Ness\Component\User\Loader\ArrayPhpFileUserLoader::loadUser()
     */
    public function testExceptionWhenNoUserLoadable(): void
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage("This user 'Foo' has been not found into ArrayPhpFileLoader");
        
        $loader = new ArrayPhpFileUserLoader([]);
        
        $loader->loadUser("Foo");
    }
    
}
