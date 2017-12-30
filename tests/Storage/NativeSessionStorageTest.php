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

namespace ZoeTest\Component\User\Storage;

use PHPUnit\Framework\TestCase;
use Zoe\Component\User\Storage\NativeSessionStorage;
use Zoe\Component\Internal\ReflectionTrait;
use Zoe\Component\User\UserInterface;
use Zoe\Component\User\Exception\UserNotFoundException;
use Zoe\Component\User\Storage\UserStorageInterface;

/**
 * NativeSessionStorage testcase
 * 
 * @see \Zoe\Component\User\Storage\NativeSessionStorage
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class NativeSessionStorageTest extends TestCase
{
    
    use ReflectionTrait;
    
    /**
     * @see \Zoe\Component\User\Storage\NativeSessionStorage::add()
     */
    public function testAdd(): void
    {
        $store = $this->getStore();
        
        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        
        $this->assertNull($store->add($user));
        $this->assertSame($user, $store->get());
    }
    
    /**
     * @see \Zoe\Component\User\Storage\NativeSessionStorage::refresh()
     */
    public function testRefresh(): void
    {
        $store = $this->getStore();
        
        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        $refreshed = $this->getMockBuilder(UserInterface::class)->getMock();
        
        $this->assertNull($store->add($user));
        $this->assertSame($user, $store->get());
        $this->assertNull($store->refresh($refreshed));
        $this->assertNotSame($user, $store->get());
        $this->assertSame($refreshed, $store->get());
    }
    
    /**
     * @see \Zoe\Component\User\Storage\NativeSessionStorage::add()
     */
    public function testGet(): void
    {
        $store = $this->getStore();
        
        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        
        $store->add($user, "Foo");
        
        $this->assertSame($user, $store->get("Foo"));
    }
    
    /**
     * @see \Zoe\Component\User\Storage\NativeSessionStorage::delete()
     */
    public function testDelete(): void
    {
        $store = $this->getStore();
        
        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        
        $store->add($user);
        
        $this->assertNull($store->delete());
    }
    
    /**
     * @see \Zoe\Component\User\Storage\NativeSessionStorage::has()
     */
    public function testHas(): void
    {
        $store = $this->getStore();
        
        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        
        $this->assertFalse($store->has());
        
        $store->add($user);
        
        $this->assertTrue($store->has());
    }
    
                    /**_____EXCEPTIONS_____**/
    
    /**
     * @see \Zoe\Component\User\Storage\NativeSessionStorage::refresh()
     */
    public function testExceptionRefreshWhenNoUser(): void
    {
        $id = UserStorageInterface::BASE_USER_ID;
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage("No user for this identifier '{$id}' has been found stored");
        
        $store = $this->getStore();
        
        $store->refresh($this->getMockBuilder(UserInterface::class)->getMock());
    }
    
    /**
     * @see \Zoe\Component\User\Storage\NativeSessionStorage::get()
     */
    public function testExceptionGetWhenNoUser(): void
    {
        $id = UserStorageInterface::BASE_USER_ID;
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage("No user for this identifier '{$id}' has been found stored");
        
        $this->getStore()->get();
    }
    
    /**
     * @see \Zoe\Component\User\Storage\NativeSessionStorage::delete()
     */
    public function testExceptionDeleteWhenNoUser(): void
    {
        $id = UserStorageInterface::BASE_USER_ID;
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage("No user for this identifier '{$id}' has been found stored");
        
        $this->getStore()->delete();
    }
    
    /**
     * Get store with session replaced by a mocked array session
     * 
     * @return NativeSessionStorage
     *   Storage mocked
     */
    private function getStore(): NativeSessionStorage
    {
        $store = new NativeSessionStorage();
        $reflection = new \ReflectionClass($store);
        $this->reflection_injectNewValueIntoProperty($store, $reflection, "session", []);
        
        return $store;
    }
    
}
