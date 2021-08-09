<?php

namespace App\Exception;

class ValidationException extends \Exception
{
    private $violations;

    public function __construct($violations)
    {
        $this->violations = $violations;
        parent::__construct('Validation failed');
    }

    public function getMessages(): array
    {
        $messages = [];
        foreach ($this->violations as $violation) {
            $messages[] = $violation->getPropertyPath() . ' - ' .$violation->getMessage();
        }

        return $messages;
    }
}