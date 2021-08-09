<?php

namespace App\Exception;

class EntityException extends \Exception
{
    public $error;

    public function __construct(string $error)
    {
        $this->error = $error;
        parent::__construct('Entity failed');
    }

    public function getError(): string
    {
        return $this->error;
    }
}