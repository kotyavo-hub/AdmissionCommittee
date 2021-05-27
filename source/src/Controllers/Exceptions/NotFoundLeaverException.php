<?php declare(strict_types=1);

namespace AC\Controllers\Exceptions;

use Exception;
use Throwable;

/**ъ
 * Class NotFoundLeaverException
 * @package AC\Controllers\Exceptions
 */
final class NotFoundLeaverException extends Exception
{
    const MESSAGE = 'Leaver not found';

    function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}