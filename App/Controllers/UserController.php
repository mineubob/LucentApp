<?php

namespace App\Controllers;

use App\Models\User;
use Lucent\Http\Message\Response;
use Lucent\Http\Message\ServerRequest;
use Lucent\Validation\Rule;

/**
 * Example controller.
 *
 * Controllers are plain classes — no base class required. Route model
 * binding resolves a type-hinted model parameter from the matching route
 * placeholder (e.g. `/{user}` -> `User $user`) and returns a 404 if the
 * record does not exist.
 */
class UserController
{
    public function create(ServerRequest $request): Response
    {
        $errors = Rule::validateRequest($request, [
            'name' => 'min:1',
            'email' => 'min:1',
        ]);

        if ($errors !== []) {
            return Response::json(['errors' => $errors], 400);
        }

        $data = $request->getParsedBody();

        $user = new User($data['name'], $data['email']);

        if (!$user->create()) {
            return Response::json(['message' => 'Failed to create user'], 500);
        }

        return Response::json(['message' => 'User created', 'id' => $user->getId()], 201);
    }

    public function show(User $user): Response
    {
        return Response::json([
            'user' => [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ],
        ], 200);
    }
}