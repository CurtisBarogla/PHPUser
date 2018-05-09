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

namespace Ness\Component\User;

use Ness\Component\User\Exception\UserAttributeNotFoundException;

/**
 * Basic implementation of UserInterface
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class User implements UserInterface
{
    
    /**
     * User name
     * 
     * @var string
     */
    protected $name;
    
    /**
     * User attributes
     * 
     * @var iterable|null
     */
    protected $attributes;
    
    /**
     * User roles
     * 
     * @var iterable|null
     */
    protected $roles;
    
    /**
     * Initialize a new basic user
     * 
     * @param string $name
     *   User name
     * @param array|null $attributes
     *   Default user's attributes
     * @param iterable|null $roles
     *   User's role
     */
    public function __construct(string $name, ?array $attributes = null, ?iterable $roles = null)
    {
        $this->name = $name;
        $this->attributes = $attributes;
        $this->roles = $roles;
    }
    
    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\UserInterface::getName()
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\UserInterface::addAttribute()
     */
    public function addAttribute(string $attribute, $value): UserInterface
    {
        $this->attributes[$attribute] = $value;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\UserInterface::getAttributes()
     */
    public function getAttributes(): ?iterable
    {
        return $this->attributes;
    }
    
    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\UserInterface::getAttribute()
     */
    public function getAttribute(string $attribute)
    {
        if(null === $this->attributes || !\array_key_exists($attribute, $this->attributes))
            throw new UserAttributeNotFoundException("This attribute '{$attribute}' is not setted into user '{$this->name}'");
            
        return $this->attributes[$attribute];
    }

    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\UserInterface::deleteAttribute()
     */
    public function deleteAttribute(string $attribute): void
    {
        if(null === $this->attributes || !\array_key_exists($attribute, $this->attributes))
            throw new UserAttributeNotFoundException("This attribute '{$attribute}' is not setted into user '{$this->name}'");
        
        unset($this->attributes[$attribute]);
    }
    
    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\UserInterface::getRoles()
     */
    public function getRoles(): ?iterable
    {
        return $this->roles;
    }

    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\UserInterface::hasRole()
     */
    public function hasRole(string $role): bool
    {
        if(null === $this->roles)
            return false;
        
        foreach ($this->roles as $userRole) {
            if($role === $userRole)
                return true;
        }
        
        return false;
    }
    
}
