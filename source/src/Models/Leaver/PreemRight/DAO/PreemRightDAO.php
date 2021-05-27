<?php

namespace AC\Models\Leaver\PreemRight\DAO;

use AC\Models\DataAccessObject;
use AC\Models\Leaver\PreemRight\DTO\PreemRightDTO;
use AC\Models\Leaver\PreemRight\DTO\PreemRightDTOCollection;
use Exception;
use ParagonIE\EasyDB\EasyStatement;

/**
 * Класс DAO для работы с таблицей приемущественных прав
 *
 * Class PreemRightDAO
 * @package AC\Models\Leaver\PreemRight\DAO
 */
class PreemRightDAO extends DataAccessObject
{
    protected const TABLE = 'onlineLeaverPreemRights';

    /**
     * Функция получает все приемущественные права абитуриента по его ID
     *
     * @param int $leaverId
     * @return array|null
     */
    public function getByLeaverId(int $leaverId): ?array
    {
        $statement = EasyStatement::open()->with('leaverId = ?', $leaverId);

        $sql = "SELECT * FROM onlineLeaverPreemRights
                WHERE $statement";

        return $this->getDB()->safeQuery($sql, $statement->values());
    }

    /**
     * @param PreemRightDTO $dto
     * @return int
     * @throws Exception
     */
    public function add(PreemRightDTO $dto): int
    {
        return $this->getDB()->insertReturnId(
            $this::TABLE,
            $dto->except('id', 'document')->toArray()
        );
    }

    /**
     * @param PreemRightDTOCollection $collection
     * @return array
     * @throws Exception
     */
    public function addMore(PreemRightDTOCollection $collection): array
    {
        $returnIds = [];

        foreach ($collection as $preemRight) {
            $this->add($preemRight);
        }

        return $returnIds;
    }
}