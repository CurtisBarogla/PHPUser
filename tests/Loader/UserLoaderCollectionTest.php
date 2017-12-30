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
use Zoe\Component\User\Loader\UserLoaderInterface;
use Zoe\Component\User\Loader\UserLoaderCollection;
use Zoe\Component\User\AuthenticationUserInterface;
use Zoe\Component\User\Exception\UserNotFoundException;

/**
 * UserLoaderCollection testcase
 * 
 * @see \Zoe\Component\User\Loader\UserLoaderCollection
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class UserLoaderCollectionTest extends TestCase
{
    
    /**
     * @see \Zoe\Component\User\Loader\UserLoaderCollection::addLoader()
     */
    public function testAddLoader(): void
    {
        $default = $this->getMockBuilder(UserLoaderInterface::class)->getMock();
        $added = $this->getMockBuilder(UserLoaderInterface::class)->getMock();
        
        $loader = new UserLoaderCollection($default);
        
        $this->assertNull($loader->addLoader($added));
    }
    
    /**
     * @see \Zoe\Component\User\Loader\UserLoaderCollection::load()
     */
    public function testLoad(): void
    {
        $userGiven = $this->getMockBuilder(AuthenticationUserInterface::class)->getMock();
        $userReturn = $this->getMockBuilder(AuthenticationUserInterface::class)->getMock();
        
        $default = $this->getMockBuilder(UserLoaderInterface::class)->getMock();
        $default->expects($this->once())->method("load")->with($userGiven)->willThrowException(new UserNotFoundException());
        $second = $this->getMockBuilder(UserLoaderInterface::class)->getMock();
        $second->expects($this->once())->method("load")->with($userGiven)->will($this->returnValue($userReturn));
        $neverCalled = $this->getMockBuilder(UserLoaderInterface::class)->getMock();
        $neverCalled->expects($this->never())->method("load");
        
        $loader = new UserLoaderCollection($default);
        $loader->addLoader($second);
        $loader->addLoader($neverCalled);
        
        $this->assertSame($userReturn, $loader->load($userGiven));
    }
    
                    /**_____EXCEPTIONS_____**/
    
    /**
     * @see \Zoe\Component\User\Loader\UserLoaderCollection::load()
     */
    public function testExceptionLoadWhenNoLoaderCanLoadAUser(): void
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage("This user 'Foo' cannot be loaded via all registered loaders");
        
        $userGiven = $this->getMockBuilder(AuthenticationUserInterface::class)->getMock();
        $userGiven->expects($this->once())->method("getName")->will($this->returnValue("Foo"));
        
        $default = $this->getMockBuilder(UserLoaderInterface::class)->getMock();
        $default->expects($this->once())->method("load")->with($userGiven)->willThrowException(new UserNotFoundException());
        $second = $this->getMockBuilder(UserLoaderInterface::class)->getMock();
        $second->expects($this->once())->method("load")->with($userGiven)->willThrowException(new UserNotFoundException());
        
        $loader = new UserLoaderCollection($default);
        $loader->addLoader($second);
        
        $loader->load($userGiven);
    }
    
}
