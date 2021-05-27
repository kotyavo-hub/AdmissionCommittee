<?php

namespace AC\Models\Leaver\IndividAchiev\DAO;

use AC\Models\DataAccessObject;
use AC\Models\Leaver\IndividAchiev\DTO\IndividAchievDTO;
use AC\Models\Leaver\IndividAchiev\DTO\IndividAchievDTOCollection;
use Exception;
use ParagonIE\EasyDB\EasyStatement;

/**
 * Класс DAO для работы с таблицей идивидуальных достижений
 *
 * Class IndividAchievDAO
 * @package AC\Models\Leaver\IndividAchiev\DAO
 */
class IndividAchievDAO extends DataAccessObject
{
    protected const TABLE = 'onlineLeaverIndividAchievs';

    /**
     * Функция получает все индивидуальные достижения абитуриента по его ID
     *
     * @param int $leaverId
     * @return array|null
     */
    public function getByLeaverId(int $leaverId): ?array
    {
        $statement = EasyStatement::open()->with('leaverId = ?', $leaverId);

        $sql = "SELECT * FROM onlineLeaverIndividAchievs
                WHERE $statement";

        return $this->getDB()->safeQuery($sql, $statement->values());
    }


    /**
     * @param IndividAchievDTO $dto
     * @return int
     * @throws Exception
     */
    public function add(IndividAchievDTO $dto): int
    {
        return $this->getDB()->insertReturnId(
            $this::TABLE,
            $dto->except('id', 'document')->toArray()
        );
    }

    /**
     * @param IndividAchievDTOCollection $collection
     * @return array
     * @throws Exception
     */
    public function addMore(IndividAchievDTOCollection $collection): array
    {
        $returnIds = [];

        foreach ($collection as $individAchiev) {
            $this->add($individAchiev);
        }

        return $returnIds;
    }
}