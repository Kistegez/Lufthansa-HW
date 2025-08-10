<?php

declare(strict_types=1);

namespace App\User\Presentation\Controller;

use App\User\Business\Contract\UserServiceInterface;
use App\User\DataSource\Mapper\UserMapper;
use App\User\Presentation\RequestHandler\CreateUserRequestHandler;
use App\User\Presentation\Responder\UserResponder;
use Exception;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/users', name: 'api_users_')]
class UserController extends AbstractController
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly UserMapper $mapper,
        private readonly CreateUserRequestHandler $createUserRequestHandler,
        private readonly UserResponder $userResponder
    ) {
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function createUser(Request $request): Response
    {
        try {
            $this->userService->createUser(
                $this->createUserRequestHandler->handle($request)
            );

            return $this->userResponder->success($request, statusCode: Response::HTTP_CREATED);
        } catch (InvalidArgumentException $e) {
            return $this->userResponder->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return $this->userResponder->error('Failed to create user', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function getUsers(Request $request): Response
    {
        try {
            $users = $this->userService->getAllUsers();

            return $this->userResponder->success(
                $request,
                $this->mapper->toArrayCollection($users)
            );
        } catch (Exception $e) {
            return $this->userResponder->error('Failed to retrieve users', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id}', name: 'show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function getUserById(int $id, Request $request): Response
    {
        try {
            $user = $this->userService->getUserById($id);

            if (!$user) {
                return $this->userResponder->error('User not found', Response::HTTP_NOT_FOUND);
            }

            return $this->userResponder->success(
                $request,
                $this->mapper->toArray($user)
            );
        } catch (InvalidArgumentException $e) {
            return $this->userResponder->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return $this->userResponder->error('Failed to retrieve user', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
