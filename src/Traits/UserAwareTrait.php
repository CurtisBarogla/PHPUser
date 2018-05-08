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

namespace Ness\Component\User\Traits;

use Ness\Component\User\UserInterface;

/**
 * Shortcut to make a component compliant with UserAwareInterface
 * 
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
trait UserAwareTrait
{
    
    /**
     * User currently linked
     * 
     * @var UserInterface
     */
    private $user;
    
    /**
     * {@inheritdoc}
     * @see \Ness\Component\User\UserAwareInterface::getUser()
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }
    
    /**
     * {@inheritdoc}
     * @see \Ness\Component\User\UserAwareInterface::setUser()
     */
    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }
    
}
