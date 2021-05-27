<?php

namespace AC\Models\Leaver\SpecRight\DAO;

use AC\Models\DataAccessObject;
use AC\Models\Leaver\SpecRight\DTO\SpecRightDTO;
use AC\Models\Leaver\SpecRight\DTO\SpecRightDTOCollection;
use Exception;
use ParagonIE\EasyDB\EasyStatement;

/**
 * Класс DAO для работы с таблицей особых прав
 *
 * Class SpecRightDAO
 * @package AC\Models\Leaver\SpecRight\DAO
 */
class SpecRightDAO extends DataAccessObject
{
    protected const TABLE = 'onlineLeaverSpecRights';

    /**
     * Функция получает все особые права абитуриента по его ID
     *
     * @param int $leaverId
     * @return array|null
     */
    public function getByLeaverId(int $leaverId): ?array
    {
        $statement = EasyStatement::open()->with('leaverId = ?', $leaverId);

        $sql = "SELECT * FROM onlineLeaverSpecRights
                WHERE $statement";

        return $this->getDB()->safeQuery($sql, $statement->values());
    }

    /**
     * @param SpecRightDTO $dto
     * @return int
     * @throws Exception
     */
    public function add(SpecRightDTO $dto): int
    {
        return $this->getDB()->insertReturnId(
            $this::TABLE,
            $dto->except('id', 'document')->toArray()
        );
    }

    /**
     * @param SpecRightDTOCollection $collection
     * @return array
     * @throws Exception
     */
    public function addMore(SpecRightDTOCollection $collection): array
    {
        $returnIds = [];

        foreach ($collection as $specRight) {
            $this->add($specRight);
        }

        return $returnIds;
    }
}