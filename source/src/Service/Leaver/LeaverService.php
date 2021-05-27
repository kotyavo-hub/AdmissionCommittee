<?php

namespace AC\Service\Leaver;

use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Exceptions\InvalidConfigException;
use AC\Config\Validation\Rules\Leaver\UniqueEmailRule;
use AC\Config\Validation\ValidationConfig;
use AC\Config\Validation\ValidationConfigKeys;
use AC\Models\File\DAO\FileDAO;
use AC\Models\File\DTO\FileDTO;
use AC\Models\Leaver\DAO\LeaverDAO;
use AC\Models\Leaver\DTO\LeaverDTO;
use Rakit\Validation\RuleQuashException;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

/**
 * Сервис для получения и сбора всех данных абитуриента
 *
 * Class ApplyingService
 * @package AC\Service\Leaver
 */
class LeaverService
{
    /**
     * @Inject
     * @var ValidationConfig
     */
    private ValidationConfig $validationConfig;

    /**
     * @Inject
     * @var Validator
     */
    private Validator $validator;

    /**
     * @Inject
     * @var LeaverDAO
     */
    private LeaverDAO $leaverDao;

    public function getLeaverById (int $id)
    {

    }
}