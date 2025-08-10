<?php

declare(strict_types=1);

namespace App\User\Presentation\RequestHandler\RequestValidatorData;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserRequestValidatorData
{
    #[Assert\NotBlank(message: 'First name is required')]
    #[Assert\Length(max: 100, maxMessage: 'First name cannot be longer than {{ limit }} characters')]
    #[Assert\Regex(pattern: '/^[a-zA-Z\s\-\'\.]+$/', message: 'First name contains invalid characters')]
    public string $firstName;

    #[Assert\NotBlank(message: 'Last name is required')]
    #[Assert\Length(max: 100, maxMessage: 'Last name cannot be longer than {{ limit }} characters')]
    #[Assert\Regex(pattern: '/^[a-zA-Z\s\-\'\.]+$/', message: 'Last name contains invalid characters')]
    public string $lastName;

    #[Assert\NotBlank(message: 'Email is required')]
    #[Assert\Email(message: 'Please provide a valid email address')]
    #[Assert\Length(max: 180, maxMessage: 'Email cannot be longer than {{ limit }} characters')]
    public string $email;

    #[Assert\NotBlank(message: 'Password is required')]
    #[Assert\Length(min: 6, minMessage: 'Password must be at least {{ limit }} characters long')]
    public string $password;

    /**
     * @param array<string,string> $data
     */
    public function __construct(array $data)
    {
        $this->firstName = $data['firstName'] ?? '';
        $this->lastName  = $data['lastName'] ?? '';
        $this->email     = $data['email'] ?? '';
        $this->password  = $data['password'] ?? '';
    }
}