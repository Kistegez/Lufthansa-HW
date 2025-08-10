<?php

declare(strict_types=1);

namespace App\Tests\User\Business\Service;

use App\User\Business\Command\CreateUserCommand;
use App\User\Business\Contract\UserRepositoryInterface;
use App\User\Business\Entity\User;
use App\User\Business\Service\UserService;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserServiceTest extends TestCase
{
    private UserRepositoryInterface $userRepository;

    private UserPasswordHasherInterface $passwordHasher;

    private UserService $userService;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $this->userService    = new UserService($this->userRepository, $this->passwordHasher);
    }

    public function testCreateUser(): void
    {
        $firstName      = 'John';
        $lastName       = 'Doe';
        $email          = 'john.doe@example.com';
        $password       = 'password123';
        $hashedPassword = 'hashed_password';

        $this->userRepository
            ->expects($this->once())
            ->method('existsByEmail')
            ->with($email)
            ->willReturn(false);

        $this->passwordHasher
            ->expects($this->once())
            ->method('hashPassword')
            ->willReturn($hashedPassword);

        $this->userRepository
            ->expects($this->once())
            ->method('save');

        $user = $this->userService->createUser(
            new CreateUserCommand($firstName, $lastName, $email, $password)
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($firstName, $user->getFirstName());
        $this->assertEquals($lastName, $user->getLastName());
        $this->assertEquals($email, $user->getEmail());
    }

    public function testCreateUserWithExistingEmailThrowsException(): void
    {
        $email = 'john.doe@example.com';
        $this->userRepository
            ->expects($this->once())
            ->method('existsByEmail')
            ->willReturn(true);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User with ' . $email . ' email already exists');

        $this->userService->createUser(
            new CreateUserCommand(
                'John',
                'Doe',
                $email,
                'password123'
            )
        );
    }

    public function testGetUserById(): void
    {
        $userId = 1;
        $user   = $this->createMock(User::class);

        $this->userRepository
            ->expects($this->once())
            ->method('findById')
            ->with($userId)
            ->willReturn($user);

        $result = $this->userService->getUserById($userId);

        $this->assertSame($user, $result);
    }

    public function testGetAllUsers(): void
    {
        $users = [
            $this->createMock(User::class),
            $this->createMock(User::class),
        ];

        $this->userRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($users);

        $result = $this->userService->getAllUsers();

        $this->assertSame($users, $result);
    }
}
