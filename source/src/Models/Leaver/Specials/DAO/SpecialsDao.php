<?php

namespace AC\Models\Leaver\Specials\DAO;

use AC\Models\DataAccessObject;
use AC\Models\Leaver\Specials\DTO\SpecialsDTO;
use AC\Models\Leaver\Specials\DTO\SpecialsDTOCollection;
use Exception;
use ParagonIE\EasyDB\EasyStatement;

/**
 * Класс DAO для работы с таблицей onlineLeaverSpecials
 *
 * Class SpecialsDao
 * @package AC\Models\Leaver\Specials\DAO
 */
class SpecialsDao extends DataAccessObject
{
    protected const TABLE = 'onlineLeaverSpecials';

    public function getByLeaverId(int $leaverId): ?array
    {
        $statement = EasyStatement::open()->with('leaverId = ?', $leaverId);

        $sql = "SELECT * FROM onlineLeaverSpecials
                WHERE $statement";

        return $this->getDB()->safeQuery($sql, $statement->values());
    }

    /**
     * @param SpecialsDTO $dto
     * @return int
     * @throws Exception
     */
    public function add(SpecialsDTO $dto): int
    {
        return $this->getDB()->insertReturnId(
            $this::TABLE,
            $dto->except('id', 'contest', 'targetDocFile')->toArray()
        );
    }

    /**
     * @param SpecialsDTOCollection $collection
     * @return array
     * @throws Exception
     */
    public function addMore(SpecialsDTOCollection $collection): array
    {
        $returnIds = [];

        foreach ($collection as $specially) {
            $this->add($specially);
        }

        return $returnIds;
    }
}