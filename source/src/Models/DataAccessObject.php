<?php

declare(strict_types=1);

namespace AC\Models;

use ParagonIE\EasyDB\EasyDB;
use ParagonIE\EasyDB\Factory;
use PDO;

/**
 * Класс обертка для дальнейшего наследоавания DTO классами
 *
 * Class DataAccessObject
 * @package AC\Models
 */
abstract class DataAccessObject
{
    /**
     * @var ?EasyDB $db_connection
     */
    private ?EasyDB $db_connection;

    public function __construct(?EasyDB $db_connection = null)
    {
        $this->db_connection = $db_connection;
        if ($this->db_connection === null) {
            $this->db_connection = Factory::fromArray(
                require __DIR__.'/../Config/database.php'
            );
        }
    }

    /**
     * Функция получения объекта для работы с БД
     * @return EasyDB
     */
    final protected function getDB(): EasyDB
    {
        return $this->db_connection;
    }
}
