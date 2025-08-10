<?php

declare(strict_types=1);

namespace App\User\Business\Command;

readonly class CreateUserCommand
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $password
    ) {
    }
}
