<?php

namespace App\Application\Validator;

use App\Application\Exception\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    protected ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @throws ValidationException
     */
    public function validate($object)
    {
        $errors = $this->validator->validate($object);
        if (count($errors) > 0) {
            throw new ValidationException((string) $errors);
        }
    }
}