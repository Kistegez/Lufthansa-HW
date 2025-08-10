<?php

declare(strict_types=1);

namespace App\User\Presentation\Exception;

use Exception;

class InvalidRequestException extends Exception
{
    public function __construct(string $message = 'Invalid request')
    {
        parent::__construct($message);
    }
}
