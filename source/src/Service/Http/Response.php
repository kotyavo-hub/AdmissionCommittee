<?php declare(strict_types=1);

namespace AC\Service\Http;

class Response implements ResponseInterface
{
    /**
     * @param string[] $resp
     */
    public function toJson(array $resp)
    {
        echo json_encode($resp);
    }

    public function renderString(string $value)
    {
        echo $value;
    }
}