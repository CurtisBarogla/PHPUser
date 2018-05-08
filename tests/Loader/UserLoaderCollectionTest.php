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
use Ness\Component\User\Loader\UserLoaderInterface;
use Ness\Component\User\Loader\UserLoaderCollection;
use Ness\Component\User\Exception\UserNotFoundException;
use Ness\Component\User\UserInterface;

/**
 * UserLoaderCollection testcase
 * 
 * @see \Ness\Component\User\Loader\UserLoaderCollection
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class UserLoaderCollectionTest extends UserTestCase
{
    
    /**
     * @see \Ness\Component\User\Loader\UserLoaderCollection::addLoader()
     */
    public function testAddLoader(): void
    {
        $loader = $this->getMockBuilder(UserLoaderInterface::class)->getMock();
        
        $collection = new UserLoaderCollection($loader);
        
        $this->assertNull($collection->addLoader($loader));
    }
    
    /**
     * @see \Ness\Component\User\Loader\UserLoaderCollection::loadUser()
     */
    public function testLoadUser(): void
    {
        $userFound = $this->getMockBuilder(UserInterface::class)->getMock();
        
        $defaultLoader = $this->getMockBuilder(UserLoaderInterface::class)->getMock();
        $added = $this->getMockBuilder(UserLoaderInterface::class)->getMock();
        $neverCalled = $this->getMockBuilder(UserLoaderInterface::class)->getMock();
        
        $defaultLoader->expects($this->once())->method("loadUser")->with("Foo")->will($this->throwException(new UserNotFoundException()));
        $added->expects($this->once())->method("loadUser")->with("Foo")->will($this->returnValue($userFound));
        $neverCalled->expects($this->never())->method("loadUser");
        
        $collection = new UserLoaderCollection($defaultLoader);
        $collection->addLoader($added);
        $collection->addLoader($neverCalled);
        
        $this->assertSame($userFound, $collection->loadUser("Foo"));
    }
    
                    /**_____EXCEPTIONS_____**/
    
    /**
     * @see \Ness\Component\User\Loader\UserLoaderCollection::loadUser()
     */
    public function testExceptionWhenNoUserCanBeLoadedOverAllRegisteredLoaders(): void 
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage("This user 'Foo' cannot be loaded over registered loaders into UserLoaderCollection");
        
        $defaultLoader = $this->getMockBuilder(UserLoaderInterface::class)->getMock();
        $added = $this->getMockBuilder(UserLoaderInterface::class)->getMock();
        
        $defaultLoader->expects($this->once())->method("loadUser")->with("Foo")->will($this->throwException(new UserNotFoundException()));
        $added->expects($this->once())->method("loadUser")->with("Foo")->will($this->throwException(new UserNotFoundException()));
        
        $collection = new UserLoaderCollection($defaultLoader);
        $collection->addLoader($added);
        
        $collection->loadUser("Foo");
    }
    
}
