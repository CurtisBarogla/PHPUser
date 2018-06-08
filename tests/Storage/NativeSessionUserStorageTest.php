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

namespace Ness\Component\User\Storage {

    $started = null;
    $result = null;
    
    /**
     * Initialize globals
     * 
     * @var int $sessionStatus
     *   Current session status. Const defined into php
     * @var bool $regenerateSuccess
     *   Returned by session_regenerate_id
     */
    function initGlobals(int $sessionStatus, bool $regenerateSuccess): void
    {
        global $started;
        global $result;
        
        $started = $sessionStatus;
        $result = $regenerateSuccess;
    }
    
    /**
     * Mock session_status
     * 
     * @return int
     *   Session status defined by call to initGlobals
     */
    function session_status()
    {
        global $started;

        return $started;
    }
    
    /**
     * Mock session_regenerate_id
     * 
     * @param bool|null $delete_old_session
     *   Mock
     *   
     * @return bool
     *   Result
     */
    function session_regenerate_id($delete_old_session = null)
    {
        global $result;
        
        return $result;
    }
    
};

namespace NessTest\Component\User\Storage {

    use NessTest\Component\User\UserTestCase;
    use Ness\Component\User\Storage\NativeSessionUserStorage;
    use Ness\Component\User\UserInterface;
    use function Ness\Component\User\Storage\initGlobals;
                                                                                    
    /**
     * NativeSessionUserStorage testcase
     * 
     * @see \Ness\Component\User\Storage\NativeSessionUserStorage
     * 
     * @author CurtisBarogla <curtis_barogla@outlook.fr>
     *
     */
    class NativeSessionUserStorageTest extends UserTestCase
    {
        
        /**
         * @see \Ness\Component\User\Storage\NativeSessionUserStorage::get()
         */
        public function testGet(): void
        {
            initGlobals(PHP_SESSION_ACTIVE, true);
            
            $user = $this->getMockBuilder(UserInterface::class)->getMock();
            $store = $this->getInitializedStore();
            $store->store($user);
            
            $this->assertSame($user, $store->get());
        }
        
        /**
         * @see \Ness\Component\User\Storage\NativeSessionUserStorage::store()
         */
        public function testStore(): void
        {
            initGlobals(PHP_SESSION_ACTIVE, true);
            
            $user = $this->getMockBuilder(UserInterface::class)->getMock();
            $store = $this->getInitializedStore(true);
            
            $this->assertTrue($store->store($user));

            initGlobals(PHP_SESSION_ACTIVE, false);
            
            $this->assertFalse($store->store($user));
            
            $store = $this->getInitializedStore();
            
            initGlobals(PHP_SESSION_ACTIVE, false);
            
            $this->assertTrue($store->store($user));
        }
        
        /**
         * @see \Ness\Component\User\Storage\NativeSessionUserStorage::refresh()
         */
        public function testRefresh(): void
        {
            initGlobals(PHP_SESSION_ACTIVE, true);
            
            $user = $this->getMockBuilder(UserInterface::class)->getMock();
            $store = $this->getInitializedStore();
            
            $this->assertFalse($store->refresh($user));
            
            initGlobals(PHP_SESSION_ACTIVE, false);
            
            $this->assertFalse($store->refresh($user));
            
            initGlobals(PHP_SESSION_ACTIVE, true);
            
            $store->store($user);
            
            $refreshed = $this->getMockBuilder(UserInterface::class)->getMock();
            
            $this->assertTrue($store->refresh($refreshed));
            $this->assertNotSame($user, $store->get());
        }
        
        /**
         * @see \Ness\Component\User\Storage\NativeSessionUserStorage::delete()
         */
        public function testDelete(): void
        {
            initGlobals(PHP_SESSION_ACTIVE, true);
            
            $user = $this->getMockBuilder(UserInterface::class)->getMock();
            $store = $this->getInitializedStore();
            
            $this->assertFalse($store->delete());
            
            $store->store($user);
            
            $this->assertTrue($store->delete());
            
            $this->assertNull($store->get());
        }
        
                        /**_____EXCEPTIONS_____**/
        
        /**
         * @see \Ness\Component\User\Storage\NativeSessionUserStorage::__construct()
         */
        public function testExceptionWhenSessionIsNotStarted(): void
        {
            $this->expectException(\LogicException::class);
            $this->expectExceptionMessage("Session MUST be active to use NativeSessionUserStorage as a storage for users");
            
            initGlobals(PHP_SESSION_DISABLED, false);
            
            $this->getInitializedStore();
        }
        
        /**
         * Initialize the tested store with a mocked session into session property
         * 
         * @return NativeSessionUserStorage
         *   Initialized tested storage
         */
        private function getInitializedStore(bool $regenerate = false): NativeSessionUserStorage
        {            
            $container = [];
            
            $store = new NativeSessionUserStorage($regenerate);
            $reflection = new \ReflectionClass($store);
            $property = $reflection->getProperty("session");
            $property->setAccessible(true);
            $property->setValue($store, $container);
            
            return $store;
        }
        
    }

}
