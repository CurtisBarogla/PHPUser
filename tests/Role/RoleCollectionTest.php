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

namespace ZoeTest\Component\User\Role;

use PHPUnit\Framework\TestCase;
use Zoe\Component\User\Role\RoleCollection;
use Zoe\Component\User\Exception\InvalidRoleException;

/**
 * RoleCollection testcase
 * 
 * @see \Zoe\Component\User\Role\RoleCollection
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class RoleCollectionTest extends TestCase
{
    
    /**
     * @see \Zoe\Component\User\Role\RoleCollection::add()
     */
    public function testAdd(): void
    {
        $collection = new RoleCollection();
        
        $this->assertNull($collection->add("Foo"));
        $this->assertNull($collection->add("Bar", ["Foo"]));
    }
    
    /**
     * @see \Zoe\Component\User\Role\RoleCollection::get()
     */
    public function testGet(): void
    {
        $collection = new RoleCollection();
        
        $collection->add("Foo");
        $collection->add("Bar", ["Foo"]);
        $collection->add("Moz", ["Bar"]);
        
        $this->assertSame(["Foo"], $collection->get("Foo"));
        $this->assertSame(["Bar", "Foo"], $collection->get("Bar"));
        $this->assertSame(["Moz", "Bar", "Foo"], $collection->get("Moz"));
    }
    
                    /**_____EXCEPTIONS_____**/
    
    /**
     * @see \Zoe\Component\User\Role\RoleCollection::add()
     */
    public function testExceptionAddWhenRoleAlreadySetted(): void
    {
        $this->expectException(InvalidRoleException::class);
        $this->expectExceptionMessage("This role 'Foo' is already registered into the collection");
        
        $collection = new RoleCollection();
        
        $collection->add("Foo");
        $collection->add("Foo");
    }
    
    /**
     * @see \Zoe\Component\User\Role\RoleCollection::add()
     */
    public function testExceptionAdWhenParentRoleNotSetted(): void
    {
        $this->expectException(InvalidRoleException::class);
        $this->expectExceptionMessage("This parent role 'Foo' for role 'Bar' cannot be setted as not defined into the collection");
        
        $collection = new RoleCollection();
        
        $collection->add("Bar", ["Foo"]);
    }
    
    /**
     * @see \Zoe\Component\User\Role\RoleCollection::get()
     */
    public function testExceptionGetWhenRoleNotSetted(): void
    {
        $this->expectException(InvalidRoleException::class);
        $this->expectExceptionMessage("This role 'Foo' is not registered into the collection");
        
        $collection = new RoleCollection();
        
        $collection->get("Foo");
    }
    
}
