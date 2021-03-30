<?php declare(strict_types=1);

namespace AC\Controllers\Exceptions;

use Exception;
use Throwable;

final class NotFoundGuidException extends Exception
{
    const MESSAGE = 'Guid parameter not found';

    function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}