<?php

namespace User\Validator;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Positive;

class UserValidator
{
    public static function forStore(): Collection
    {
        return new Collection([
            'name' => [
                new NotBlank(message: 'Nama wajib diisi.'),
                new Type(type: 'string', message: 'Nama harus berupa teks.'),
            ],
            'umur' => [
                new NotBlank(message: 'Umur wajib diisi.'),
                new Type(type: 'integer', message: 'Umur harus berupa angka.'),
                new Positive(message: 'Umur harus lebih dari 0.'),
            ],
        ]);
    }
}
