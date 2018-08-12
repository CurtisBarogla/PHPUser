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

use Ness\Component\User\Exception\InvalidUserAttributeException;
use Ness\Component\User\Exception\InvalidUserAttributeValueException;

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
     *   When an attribute name or value is invalid
     */
    public function __construct(string $name, ?array $attributes = null, ?iterable $roles = null)
    {
        $this->name = $name;
        (null !== $attributes) ? \array_walk($attributes, function($value, string $attribute): void {
            $this->addAttribute($attribute, $value);
        }) : $this->attributes = null;
        $this->roles = (null === $roles) ? null : \array_unique($roles);
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
        
        if(
            \is_resource($value) || 
            ($value instanceof \Closure && \is_callable($value)) || 
            (\is_object($value) && (new \ReflectionClass($value))->isAnonymous()))
            throw new InvalidUserAttributeValueException("Cannot store this attribute '{$attribute}' as its value is invalid");
            
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
        return $this->attributes[$attribute] ?? null;
    }

    /**
     * {@inheritDoc}
     * @see \Ness\Component\User\UserInterface::deleteAttribute()
     */
    public function deleteAttribute(string $attribute): void
    {
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
        return (null !== $this->roles) ? \in_array($role, $this->roles) : false;
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
