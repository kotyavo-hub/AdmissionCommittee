<?php declare(strict_types=1);

namespace AC\Service\Http;

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
}