<?php declare(strict_types=1);

namespace AC\Service\Http;

/**
 * Интерфейс для класса Request
 *
 * @see Request
 * Interface RequestInterface
 * @package AC\Service\Http
 */
interface RequestInterface
{
    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return string
     */
    public function getUri(): string;

    /**
     * @param string $type
     * @param string $parameter
     * @return null|string
     */
    public function getRequestParam(string $type, string $parameter);

    public function sendMethodNotAllowedHeader();

    public function sendNotFoundHeader();
}