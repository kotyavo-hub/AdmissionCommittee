<?php declare(strict_types=1);

namespace AC\Controllers\Exceptions;

use Exception;
use Throwable;

/**ъ
 * Class NotFoundDocumentException
 * @package AC\Controllers\Exceptions
 */
final class NotFoundDocumentException extends Exception
{
    const MESSAGE = 'Document not found';

    function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}