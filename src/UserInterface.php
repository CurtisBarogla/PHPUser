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
use Ness\Component\User\Exception\UserAttributeNotFoundException;

/**
 * Describe a basic user interacting with an application. 
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
interface UserInterface
{
    
    /**
     * Get user name
     * 
     * @return string
     *   User name
     */
    public function getName(): string;
    
    /**
     * Add an attribute into the user.
     * Attribute MUST respect [a-zA-Z0-9_] pattern
     * 
     * @param string $attribute
     *   Attribute identifier
     * @param mixed $value
     *   Value to associate to this attribute
     * 
     * @return UserInterface
     *   Fluent
     *   
     * @throws InvalidUserAttributeException
     *   When given attribute name is invalid
     */
    public function addAttribute(string $attribute, $value): UserInterface;
    
    /**
     * Get all attributes setted into the user
     * 
     * @return iterable|null
     *   All attribute or null if none has been setted
     */
    public function getAttributes(): ?iterable;
    
    /**
     * Get an attribute from the user
     * 
     * @param string $attribute
     *   Attribute to get
     * 
     * @return mixed
     *   Must return exact value assigned to the asked attribute
     *   
     * @throws UserAttributeNotFoundException
     *   When given attribute is not setted
     */
    public function getAttribute(string $attribute);
    
    /**
     * Delete an attribute attached to the user
     * 
     * @param string $attribute
     *   Attribute identifier
     *   
     * @throws UserAttributeNotFoundException
     *   When given attribute it not setted
     */
    public function deleteAttribute(string $attribute): void;
    
    /**
     * Get all roles associated to this user.
     * If no role has been previously setted, MUST return null
     * 
     * @return iterable[string]|null
     *   All roles or null
     */
    public function getRoles(): ?iterable;
    
    /**
     * Check if the user has a specific role
     * 
     * @param string $role
     *   Role to check
     * 
     * @return bool
     *   True if the user holds this role. False otherwise
     */
    public function hasRole(string $role): bool;
    
}
