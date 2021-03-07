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
}