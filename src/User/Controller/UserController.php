<?php

namespace User\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UserController
{
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

    public function render() {}

    public function index()
    {
        return new Response(
            json_encode([
                'message' => 'success',
                'data' => $this->users
            ])
        );
    }

    public function store(Request $request): Response
    {
        $data = $request->toArray();
        $name = $data['name'] ?? null;
        $umur = $data['umur'] ?? null;

        // todo: implement validation

        return new Response(json_encode(
            [
                'message' => 'success',
                'name' => 'nama km adalah: ' . $name,
                'umur' => 'umur km adalah: ' . $umur
            ]
        ));
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
