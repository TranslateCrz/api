<?php

namespace App\Application\Validator;

use App\Application\Exception\Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    protected ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @throws Exception
     */
    public function validate($object)
    {
        $errors = $this->validator->validate($object);
        if (count($errors) > 0) {
            throw new Exception((string) $errors); // @phpstan-ignore-line
        }
    }
}
