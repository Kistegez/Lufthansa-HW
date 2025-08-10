<?php

declare(strict_types=1);

namespace App\User\Business\Contract;

use App\User\Business\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(int $userId): ?User;

    /**
     * @return User[]
     */
    public function findAll(): array;

    public function existsByEmail(string $email): bool;
}
