<?php

namespace AC\Models\Dictionary\DAO;

use AC\Models\DataAccessObject;
use AC\Models\Dictionary\Enum\DictionaryTableEnum;

/**
 * Класс DAO для работы с таблицами справочников
 *
 * Class DictionaryDAO
 * @package AC\Models\Dictionary\DAO
 */
class DictionaryDAO extends DataAccessObject
{
    /**
     * Получает все поля из таблицы справочника
     *
     * @param DictionaryTableEnum $table
     * @return array|bool|int|object
     */
    public function getAll(DictionaryTableEnum $table)
    {
        $tableKey = $table->getValue();
        return $this->getDB()->safeQuery("SELECT * FROM $tableKey");
    }
}