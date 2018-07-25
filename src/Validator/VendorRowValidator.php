<?php

namespace App\Validator;

use Symfony\Component\Validator\Exception\ValidatorException;

class VendorRowValidator
{
    public function validate(array $row): void
    {
        if (\count($row) !== 3) {
            throw new ValidatorException('Incorrect line in file.'.implode(';', $row));
        }
    }
}