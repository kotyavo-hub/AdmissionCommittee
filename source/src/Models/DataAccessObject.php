<?php

declare(strict_types=1);

namespace AC\Models;

use ParagonIE\EasyDB\EasyDB;
use ParagonIE\EasyDB\Factory;
use PDO;

abstract class DataAccessObject
{
    private $db_connection;

    public function __construct(?EasyDB $db_connection = null)
    {
        $this->db_connection = $db_connection;
        if ($this->db_connection === null) {
            $this->db_connection = Factory::fromArray(
                require __DIR__.'/../Config/database.php'
            );
        }
    }

    final protected function getDB(): EasyDB
    {
        return $this->db_connection;
    }
}
