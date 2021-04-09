<?php declare(strict_types=1);

namespace AC\Controllers\API\Exceptions;

use Exception;
use Throwable;

final class NotFoundRequiredUrovOrExamsParamsException extends Exception
{
    const MESSAGE = 'urov or exams parameter not found';

    function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}