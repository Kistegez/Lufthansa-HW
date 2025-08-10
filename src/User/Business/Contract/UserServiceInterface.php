<?php

declare(strict_types=1);

namespace App\User\Business\Contract;

use App\User\Business\Command\CreateUserCommand;
use App\User\Business\Entity\User;

interface UserServiceInterface
{
    public function createUser(CreateUserCommand $command): User;

    public function getUserById(int $userId): ?User;

    /**
     * @return User[]
     */
    public function getAllUsers(): array;
}
