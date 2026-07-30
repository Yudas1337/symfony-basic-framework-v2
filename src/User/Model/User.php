<?php

namespace User\Model;

class User
{
    public function isOddYear(int $year): bool
    {
        return 1 == $year % 2;
    }
}
