<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Collection;

class UserNotSupervisorException extends Exception
{
    public static function hasRoles(Collection $roles): static
    {
        $message = 'The user given has roles: ' . $roles->implode(', ');

        return new static($message);
    }
}
