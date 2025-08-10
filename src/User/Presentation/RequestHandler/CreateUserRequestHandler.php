<?php

declare(strict_types=1);

namespace App\User\Presentation\RequestHandler;

use App\User\Business\Command\CreateUserCommand;
use App\User\Presentation\Exception\InvalidRequestException;
use App\User\Presentation\RequestHandler\RequestValidatorData\CreateUserRequestValidatorData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Yaml\Yaml;

readonly class CreateUserRequestHandler
{
    public function __construct(
        private ValidatorInterface $dataValidator,
    ) {
    }

    public function handle(Request $request): CreateUserCommand
    {
        $data = $this->getRequestFormat($request) === 'yaml'
            ? Yaml::parse($request->getContent())
            : json_decode($request->getContent(), true);

        if (!$data) {
            throw new InvalidRequestException('Invalid data');
        }

        $errors = $this->dataValidator->validate(new CreateUserRequestValidatorData($data));
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            throw new InvalidRequestException(
                'Validation failed: ' . implode(', ', $errorMessages)
            );
        }

        return new CreateUserCommand(
            $data['firstName'],
            $data['lastName'],
            $data['email'],
            $data['password']
        );
    }

    private function getRequestFormat(Request $request): string
    {
        $contentType = $request->headers->get('Content-Type', '');

        if (str_contains($contentType, 'application/yaml') || str_contains($contentType, 'text/yaml')) {
            return 'yaml';
        }

        return 'json';
    }
}
