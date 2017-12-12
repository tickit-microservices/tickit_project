<?php

namespace app\exceptions;

use Exception;
use Throwable;

class EntityValidationException extends Exception
{
    private $errors = [];

    /**
     * @inheritdoc
     */
    public function __construct($errors = [], string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }
}