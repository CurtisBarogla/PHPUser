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

/**
 * Authenticated user
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
final class AuthenticatedUser extends User implements AuthenticatedUserInterface
{
    
    /**
     * Authentication datetime
     * 
     * @var \DateTimeInterface
     */
    private $authenticatedAt;
    
    /**
     * Initialize authenticated user
     * 
     * @param string $name
     *   User name
     * @param \DateTimeInterface $authenticatedAt
     *   Authentication time
     * @param bool $isRoot
     *   If the user if root
     * @param array|null $attributes
     *   Defaults attributes
     * @param array|null $roles
     *   Defaults roles
     */
    public function __construct(
        string $name, 
        \DateTimeInterface $authenticatedAt, 
        bool $isRoot = false, 
        ?array $attributes = null, 
        ?array $roles = null)
    {
        parent::__construct($name, $isRoot, $attributes, $roles);
        $this->authenticatedAt = $authenticatedAt;
    }
    
    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\AuthenticatedUserInterface::authenticatedAt()
     */
    public function authenticatedAt(): \DateTimeInterface
    {
        return $this->authenticatedAt;
    }

    /**
     * {@inheritDoc}
     * @see \JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize(): array
    {
        return [
            "name"          =>  $this->name,
            "root"          =>  $this->isRoot,
            "timestamp"     =>  "@{$this->authenticatedAt->getTimestamp()}",
            "timezone"      =>  $this->authenticatedAt->getTimezone()->getName(),
            "attributes"    =>  $this->attributes,
            "roles"         =>  $this->roles
        ];
    }

    /**
     * {@inheritDoc}
     * @see \Zoe\Component\User\AuthenticatedUserInterface::restore()
     */
    public static function restore($json): AuthenticatedUserInterface
    {
        if(!\is_array($json))
            $json = \json_decode($json, true);
        
        return new AuthenticatedUser(
            $json["name"], 
            (new \DateTimeImmutable($json["timestamp"]))->setTimezone(new \DateTimeZone($json["timezone"])), 
            $json["root"], 
            $json["attributes"], 
            $json["roles"]);
    }
    
    /**
     * Initialize an authenticated user from its authentication version
     * 
     * @param AuthenticationUserInterface $user
     *   Authentication user
     * 
     * @return AuthenticatedUser
     *   Authenticated user from its Authentication version
     */
    public static function createFromAuthenticationUser(AuthenticationUserInterface $user): AuthenticatedUserInterface
    {
        return new AuthenticatedUser($user->getName(), new \DateTime(), $user->isRoot(), $user->getAttributes(), $user->getRoles());
    }

}
