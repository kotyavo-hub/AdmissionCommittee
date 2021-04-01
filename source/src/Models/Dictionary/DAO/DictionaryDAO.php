<?php

namespace AC\Models\Dictionary\DAO;

use AC\Models\DataAccessObject;
use AC\Models\Dictionary\Enum\DictionaryTableEnum;

class DictionaryDAO extends DataAccessObject
{
    public function getAll(DictionaryTableEnum $table)
    {
        $tableKey = $table->getValue();
        return $this->getDB()->safeQuery("SELECT * FROM $tableKey");
    }
}