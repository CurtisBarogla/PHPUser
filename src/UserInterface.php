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
 * Basic user
 * Common to all sub user
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
interface UserInterface
{
    
    /**
     * Get username
     * 
     * @return string
     *   Username
     */
    public function getName(): string;
    
    /**
     * Check if the user is root
     * 
     * @return bool
     *   True if the user is root. False otherwise
     */
    public function isRoot(): bool;
    
    /**
     * Add an attribute
     * 
     * @param string $attribute
     *   Attribute name
     * @param mixed $value
     *   Attribute value
     */
    public function addAttribute(string $attribute, $value): void;
    
    /**
     * Get all attributes attached to the user.
     * Will return if the user has no attribute
     * 
     * @return iterable|null
     *   All attributes or null
     */
    public function getAttributes(): ?iterable;
    
    /**
     * Get an attribute
     * 
     * @param string $attribute
     *   Attribute name
     *  
     * @return mixed
     *   Attribute value
     *  
     * @throws InvalidUserAttributeException
     *   If the user has not the requested attribute
     */
    public function getAttribute(string $attribute);
    
    /**
     * Check if the user has an attribute
     * 
     * @param string $attribute
     *   Attribute name
     * 
     * @return bool
     *   True if the user has the given attribute. False otherwise
     */
    public function hasAttribute(string $attribute): bool;
    
    /**
     * Get all user roles.
     * Will return null if the user has no role
     * 
     * @return iterable|null
     *   All roles or null
     */
    public function getRoles(): ?iterable;
    
    /**
     * Check if the user has the given role
     * 
     * @param string $role
     *   Role name
     * 
     * @return bool
     *   True if the user has the given role. False otherwise
     */
    public function hasRole(string $role): bool;
    
}
