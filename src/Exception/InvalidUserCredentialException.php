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

namespace Zoe\Component\User\Exception;

/**
 * When an invalid user credential is requested
 *
 * @author CurtisBarogla <curtis_barogla@outlook.fr>
 *
 */
class InvalidUserCredentialException extends \InvalidArgumentException
{
    //
}