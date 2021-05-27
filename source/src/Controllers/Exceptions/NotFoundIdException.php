<?php declare(strict_types=1);

namespace AC\Controllers\Exceptions;

use Exception;
use Throwable;

/**ъ
 * Class NotFoundIdException
 * @package AC\Controllers\Exceptions
 */
final class NotFoundIdException extends Exception
{
    const MESSAGE = 'Id parameter not found';

    function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}