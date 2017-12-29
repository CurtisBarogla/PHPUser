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
 * User considered valid.
 * No credential are available now
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
interface AuthenticatedUserInterface extends UserInterface, \JsonSerializable
{
    
    /**
     * Get authentication datetime
     * 
     * @return \DateTimeInterface
     *   Authentication datetime
     */
    public function authenticatedAt(): \DateTimeInterface;
    
    /**
     * Restore an authenticated user from is json representation.
     * This json representation can be either a string or an array 
     * 
     * @param string|array $json
     *   String or array AuthenticatedUserInterface representation
     * 
     * @return AuthenticatedUserInterface
     *   Restored authenticated user
     */
    public static function restore($json): AuthenticatedUserInterface;
    
}
