<?php

declare(strict_types=1);

namespace App\User\Business\Service;

use App\User\Business\Command\CreateUserCommand;
use App\User\Business\Contract\UserRepositoryInterface;
use App\User\Business\Contract\UserServiceInterface;
use App\User\Business\Entity\User;
use InvalidArgumentException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function createUser(CreateUserCommand $command): User
    {
        if ($this->userRepository->existsByEmail($command->email)) {
            throw new InvalidArgumentException('User with ' . $command->email . ' email already exists');
        }

        $user = new User(
            $command->firstName,
            $command->lastName,
            $command->email,
        );

        $user->setHashedPassword(
            $this->passwordHasher->hashPassword($user, $command->password)
        );

        $this->userRepository->save($user);

        return $user;
    }

    public function getUserById(int $userId): ?User
    {
        return $this->userRepository->findById($userId);
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }
}
