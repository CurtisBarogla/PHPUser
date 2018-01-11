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
use Zoe\Component\User\Loader\LoadedUserAwareTrait;
use Zoe\Component\User\AuthenticationUserInterface;

/**
 * LoadedUserAwareTrait testcase
 * 
 * @see \Zoe\Component\User\Loader\LoadedUserAwareTrait
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class LoadedUserAwareTraitTest extends TestCase
{
    
    /**
     * @see \Zoe\Component\User\Loader\LoadedUserAwareTrait::setUser()
     */
    public function testSetUser(): void
    {
        $trait = $this->getMockForTrait(LoadedUserAwareTrait::class);
        $user = $this->getMockBuilder(AuthenticationUserInterface::class)->getMock();
        
        $this->assertNull($trait->setUser($user));
    }
    
    /**
     * @see \Zoe\Component\User\Loader\LoadedUserAwareTrait::getUser()
     */
    public function testGetUser(): void
    {
        $trait = $this->getMockForTrait(LoadedUserAwareTrait::class);
        $user = $this->getMockBuilder(AuthenticationUserInterface::class)->getMock();
        
        $trait->setUser($user);
        
        $this->assertSame($user, $trait->getUser());
    }
    
}
