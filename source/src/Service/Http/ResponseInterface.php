<?php declare(strict_types=1);

namespace AC\Service\Http;

use AC\Service\Http\Enum\HttpCodeEnum;

/**
 * Интерфейс для отправки данных пользователю
 *
 * @see Response
 * Interface ResponseInterface
 * @package AC\Service\Http
 */
interface ResponseInterface
{
    /**
     * @param string[] $resp
     */
    public function toJson(array $resp);

    /**
     * @param string $value
     */
    public function renderString(string $value);

    /**
     * @param $key
     * @param $param
     * @return mixed
     */
    public function setParamFromSessionVar($key, $param);

    /**
     * @param string $template
     * @param array $data
     */
    public function display(string $template, array $data = []);

    /**
     * @param string $url
     * @return mixed
     */
    public function redirect(string $url);

    /**
     * @return mixed
     */
    public function destroySession();

    /**
     * @param string $param
     * @return void
     */
    public function setHeader(string $param): void;

    /**
     * @param HttpCodeEnum $code
     * @return void
     */
    public function setCode(HttpCodeEnum $code): void;
}