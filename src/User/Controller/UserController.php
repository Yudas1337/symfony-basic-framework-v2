<?php

namespace User\Controller;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use User\Event\UserCreatedEvent;
use User\Validator\UserValidator;
use \User\Model\User;

class UserController
{
    public function __construct(
        private ?EventDispatcher $dispatcher = null,
        private ?ValidatorInterface $validator = null,
    ) {
        $this->validator = Validation::createValidator();
    }

    private $users = [
        [
            'id' => 1,
            'name' => 'Yudas',
            'umur' => 25
        ],
        [
            'id' => 2,
            'name' => 'Malabi',
            'umur' => 50
        ]
    ];

    public function userpage(Request $request, string $title): Response
    {
        $request->attributes->set('users', $this->users);
        $request->attributes->set('title', $title);

        return render_template($request);
    }

    public function index()
    {
        $check = new User();

        $data = array_map(function ($user) use ($check) {
            $user['is_odd_year'] = $check->isOddYear($user['umur']);
            return $user;
        }, $this->users);

        return new Response(
            json_encode([
                'message' => 'success',
                'data' => $data
            ])
        );
    }

    public function store(Request $request): Response
    {
        $data = $request->toArray();
        $name = $data['name'] ?? null;
        $umur = $data['umur'] ?? null;

        $violations = $this->validator->validate($data, UserValidator::forStore());

        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[trim($violation->getPropertyPath(), '[]')] = $violation->getMessage();
            }

            return new Response(json_encode([
                'message' => 'validation failed',
                'errors' => $errors,
            ]), 422);
        }

        $response = new Response(json_encode(
            [
                'message' => 'success',
                'name' => 'nama km adalah: ' . $name,
                'umur' => 'umur km adalah: ' . $umur
            ]
        ));

        $this->dispatcher?->dispatch(new UserCreatedEvent(['name' => $name, 'umur' => $umur]), UserCreatedEvent::class);

        return $response;
    }

    public function show(int $id)
    {
        if (!$id) {
            return new Response('User Not Found', 404);
        }

        $match = array_filter($this->users, fn($user) => $user['id'] === $id);

        if (empty($match)) {
            return new Response('User Not Found', 404);
        }

        return new Response(json_encode([
            'data' => array_values($match)
        ]));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->toArray();
        $name = $data['name'] ?? null;
        $umur = $data['umur'] ?? null;

        if (!$id) {
            return new Response('User Not Found', 404);
        }

        $match = array_filter($this->users, fn($user) => $user['id'] === $id);

        // todo: implement validation
        if (empty($match)) {
            return new Response('User Not Found', 404);
        }

        return new Response(json_encode(
            [
                'message' => 'success',
                'name' => "nama km adalah: $name",
                'umur' => "umur km adalah: $umur"
            ]
        ));
    }

    public function destroy(int $id)
    {
        if (!$id) {
            return new Response('User Not Found', 404);
        }

        return new Response('User ' . $id . ' dihapus');
    }
}
