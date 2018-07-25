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
use Ness\Component\User\Exception\InvalidUserAttributeException;

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
     *   
     * @throws InvalidUserAttributeException
     *   When an attribute name is invalid
     */
    public function __construct(string $name, ?array $attributes = null, ?iterable $roles = null)
    {
        $this->name = $name;
        (null !== $attributes) ? \array_walk($attributes, function($value, string $attribute): void {
            $this->addAttribute($attribute, $value);
        }) : $this->attributes = null;
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
        if(0 === \preg_match("#^[a-zA-Z0-9_]+$#", $attribute))
            throw new InvalidUserAttributeException("Attribute name '{$attribute}' does not respect attribute name convention pattern [a-zA-Z0-9_]");
        
        if(null === $value)
            throw new InvalidUserAttributeException("Cannot set this attribute '{$attribute}'. Null value denied");
            
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
        if(!isset($this->attributes[$attribute]))
            throw new UserAttributeNotFoundException("This attribute '{$attribute}' is not setted into user '{$this->name}'");
            
        return $this->attributes[$attribute];
    }

    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\UserInterface::deleteAttribute()
     */
    public function deleteAttribute(string $attribute): void
    {
        if(!isset($this->attributes[$attribute]))
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
    
    /**
     * Output username
     * 
     * @return string
     *   Output user name
     */
    public function __toString()
    {
        return $this->name;
    }
    
}
