<?php declare(strict_types=1);

namespace AC\Controllers\Exceptions;

use Exception;
use Throwable;

/**
 * Class NotFoundEmailHashException
 * @package AC\Controllers\Exceptions
 */
final class NotFoundEmailHashException extends Exception
{
    const MESSAGE = 'Email hash parameter not found';

    function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}