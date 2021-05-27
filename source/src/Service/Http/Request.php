<?php declare(strict_types=1);

namespace AC\Service\Http;

use AC\Models\User\DTO\UserDTO;
use AC\Models\User\User;

/**
 * Сервис-обертка над глобальными массивами
 *
 * Class Request
 * @package AC\Service\Http
 */
class Request implements RequestInterface
{
    const METHOD = 'REQUEST_METHOD';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    const FILES = 'FILES';
    const SESSION = 'SESSION';

    const URI = 'REQUEST_URI';
    const SERVER_PROTOCOL = 'SERVER_PROTOCOL';

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $_SERVER[static::METHOD];
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $_SERVER[static::URI];
    }

    public function sendMethodNotAllowedHeader()
    {
        header($this->getServerProtocol() . ' 405 Method Not Allowed');
    }

    public function sendNotFoundHeader()
    {
        header($this->getServerProtocol() . ' 404 Not Found');
    }

    /**
     * @param string $type
     * @param string $parameter
     * @return null|string
     */
    public function getRequestParam(string $type, string $parameter)
    {
        switch ($type) {
            case static::METHOD_GET:
                $parameterValue = $this->getParamFromGetVar($parameter);
                break;
            case static::METHOD_POST:
                $parameterValue = $this->getParamFromPostVar($parameter);
                break;
            case static::SESSION:
                $parameterValue = $this->getParamFromSessionVar($parameter);
                break;
            case static::FILES:
                $parameterValue = $this->getFileFromPostVar($parameter);
            default:
                $parameterValue = null;
        }

        return $parameterValue;
    }

    /**
     * @param string $parameter
     * @return null|string
     */
    public function getParamFromGetVar(string $parameter)
    {
        return $this->getParamFromVar($parameter, $_GET);
    }

    /**
     * @return UserDTO|null
     */
    public function getUser()
    {
        $user = $this->getParamFromSessionVar('User');

        if ($user instanceof UserDTO) {
            return $user;
        }

        return null;
    }

    /**
     * @param string $parameter
     * @return null|string
     */
    public function getParamFromSessionVar(string $parameter)
    {
        session_start();
        return $this->getParamFromVar($parameter, $_SESSION);
    }


    /**
     * @param string $parameter
     * @return null|string|array
     */
    public function getParamFromPostVar(string $parameter)
    {
        return $this->getParamFromVar($parameter, $_POST);
    }

    /**
     * @param string $parameter
     * @return array|string|null
     */
    public function getFileFromPostVar(string $parameter)
    {
        return $this->getParamFromVar($parameter, $_FILES);
    }

    /**
     * @param string $parameter
     * @param array $var
     * @return string|null|array
     */
    public function getParamFromVar(string $parameter, array $var)
    {
        if (array_key_exists($parameter, $var)) {
            return $var[$parameter];
        }

        return null;
    }

    public function getServerProtocol()
    {
        return $_SERVER[static::SERVER_PROTOCOL];
    }
}