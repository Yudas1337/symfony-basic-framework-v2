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
            'name' => [new NotBlank(), new Type('string')],
            'umur' => [new NotBlank(), new Type('integer'), new Positive()],
        ]);
    }
}
