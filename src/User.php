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

namespace Zoe\Component\User;

use Zoe\Component\User\Exception\InvalidUserAttributeException;

/**
 * Base for all users
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
abstract class User implements UserInterface
{
    
    /**
     * User name
     * 
     * @var string
     */
    protected $name;
    
    /**
     * Is root
     * 
     * @var bool
     */
    protected $isRoot;
    
    /**
     * User attributes
     * 
     * @var array|null
     */
    protected $attributes = null;
    
    /**
     * User roles
     * 
     * @var array|null
     */
    protected $roles = null;
    
    /**
     * Initialize a user
     * 
     * @param string $name
     *   User name
     * @param bool $isRoot
     *   If the user if root
     * @param array|null $attributes
     *   Defaults attributes
     * @param array|null $roles
     *   Defaults roles
     */
    public function __construct(string $name, bool $isRoot = false, ?array $attributes = null, ?array $roles = null)
    {
        $this->name = $name;
        $this->isRoot = $isRoot;
        $this->attributes = $attributes;
        $this->roles = (null !== $roles) ? \array_combine($roles, $roles) : null;
    }
    
    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\UserInterface::getName()
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\UserInterface::isRoot()
     */
    public function isRoot(): bool
    {
        return $this->isRoot;
    }
    
    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\UserInterface::addAttribute()
     */
    public function addAttribute(string $attribute, $value): void
    {
        $this->attributes[$attribute] = $value;
    }

    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\UserInterface::getAttributes()
     */
    public function getAttributes(): ?iterable
    {
        return $this->attributes;
    }

    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\UserInterface::getAttribute()
     */
    public function getAttribute(string $attribute)
    {
        if(!$this->hasAttribute($attribute))
            throw new InvalidUserAttributeException(\sprintf("This attribute '%s' for user '%s' is invalid",
                $attribute,
                $this->name));
            
        return $this->attributes[$attribute];
    }

    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\UserInterface::hasAttribute()
     */
    public function hasAttribute(string $attribute): bool
    {
        try {
            return \array_key_exists($attribute, $this->attributes);
        } catch (\TypeError $e) {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\UserInterface::getRoles()
     */
    public function getRoles(): ?iterable
    {
        return $this->roles;
    }
    
    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\UserInterface::hasRole()
     */
    public function hasRole(string $role): bool
    {
        return isset($this->roles[$role]);
    }

}
