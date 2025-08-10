<?php

declare(strict_types=1);

namespace App\User\Presentation\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class UserResponder
{
    public function __construct(
        private readonly SerializerInterface $serializer
    ) {
    }

    public function success(
        Request $request,
        array $data = [],
        int $statusCode = Response::HTTP_OK,
    ): Response {
        if ($this->getResponseFormat($request) === 'yaml') {
            $content = $this->serializer->serialize($data, 'yaml');

            return new Response($content, $statusCode, ['Content-Type' => 'application/yaml']);
        }

        return new JsonResponse($data, $statusCode);
    }

    public function error(string $message, int $statusCode): Response
    {
        return new JsonResponse(['error' => $message], $statusCode);
    }

    private function getResponseFormat(Request $request): string
    {
        // Check Accept header first
        $acceptHeader = $request->headers->get('Accept', '');
        if (str_contains($acceptHeader, 'application/yaml') || str_contains($acceptHeader, 'text/yaml')) {
            return 'yaml';
        }

        // Check format query parameter
        $format = $request->query->get('format', 'json');

        return in_array($format, ['json', 'yaml']) ? $format : 'json';
    }
}
