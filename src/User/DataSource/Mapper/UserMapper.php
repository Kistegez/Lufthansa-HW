<?php

declare(strict_types=1);

namespace App\User\DataSource\Mapper;

use App\User\Business\Entity\User;

class UserMapper
{
    public function toArray(User $user): array
    {
        return [
            'id'        => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName'  => $user->getLastName(),
            'email'     => $user->getEmail(),
            'createdAt' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @param User[] $users
     *
     * @return array[]
     */
    public function toArrayCollection(array $users): array
    {
        return [
            'users' => array_map([$this, 'ToArray'], $users),
        ];
    }
}
