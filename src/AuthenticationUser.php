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

use Zoe\Component\User\Exception\InvalidUserCredentialException;

/**
 * Authentication user
 * This implementation offer mutability over credentials
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
final class AuthenticationUser extends User implements AuthenticationUserInterface
{
    
    /**
     * User credentials
     * 
     * @var array|null
     */
    private $credentials;
    
    /**
     * Initialize authentication user
     * 
     * @param string $name
     *   User name
     * @param string|null $password
     *   User password. Can be null
     * @param bool $isRoot
     *   If the user if root
     * @param array|null $attributes
     *   Defaults attributes
     * @param array|null $roles
     *   Defaults roles
     * @param array|null $credentials
     *   Defaults credentials
     */
    public function __construct(
        string $name, 
        ?string $password = null, 
        bool $isRoot = false, 
        ?array $attributes = null, 
        ?array $roles = null,
        ?array $credentials = null)
    {
        parent::__construct($name, $isRoot, $attributes, $roles);
        $this->credentials = $credentials;
        $this->credentials["USER_PASSWORD"] = $password;
    }
    
    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\AuthenticationUserInterface::getPassword()
     */
    public function getPassword(): ?string
    {
        return $this->credentials["USER_PASSWORD"];
    }
    
    /**
     * Add a credential
     * 
     * @param string $credential
     *   Credential name
     * @param mixed $value
     *   Credential value
     */
    public function addCredential(string $credential, $value): void
    {
        $this->credentials[$credential] = $value;
    }
    
    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\AuthenticationUserInterface::getCredentials()
     */
    public function getCredentials(): ?iterable
    {
        return $this->credentials;
    }

    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\AuthenticationUserInterface::getCredential()
     */
    public function getCredential(string $credential)
    {
        if(!\array_key_exists($credential, $this->credentials))
            throw new InvalidUserCredentialException(\sprintf("This credential '%s' for user '%s' is invalid",
                $credential,
                $this->name));
            
        return $this->credentials[$credential];
    }

}
