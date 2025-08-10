<?php

declare(strict_types=1);

namespace App\Tests\User\Business\Domain;

use App\User\Business\Entity\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private string $firstName = 'John';

    private string $lastName = 'Doe';

    private string $email = 'john.doe@example.com';

    private string $hashedPassword;

    protected function setUp(): void
    {
        $this->hashedPassword = 'hashed_password_123';
    }

    public function testUserCreation(): void
    {
        $user = new User($this->firstName, $this->lastName, $this->email);
        $user->setHashedPassword($this->hashedPassword);

        $this->assertEquals($this->firstName, $user->getFirstName());
        $this->assertEquals($this->email, $user->getEmail());
        $this->assertEquals($this->hashedPassword, $user->getPassword());
        $this->assertInstanceOf(DateTimeImmutable::class, $user->getCreatedAt());
    }

    public function testToArray(): void
    {
        $user = new User($this->firstName, $this->lastName, $this->email);
        $user->setHashedPassword($this->hashedPassword);
        $array = $user->toArray();

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('firstName', $array);
        $this->assertArrayHasKey('lastName', $array);
        $this->assertArrayHasKey('email', $array);
        $this->assertArrayHasKey('createdAt', $array);

        $this->assertEquals('John', $array['firstName']);
        $this->assertEquals('Doe', $array['lastName']);
        $this->assertEquals('john.doe@example.com', $array['email']);
    }
}
