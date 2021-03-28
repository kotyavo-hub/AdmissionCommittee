<?php

namespace AC\Service\Leaver;

use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Exceptions\InvalidConfigException;
use AC\Config\Validation\Rules\Leaver\UniqueEmailRule;
use AC\Config\Validation\ValidationConfig;
use AC\Config\Validation\ValidationConfigKeys;
use AC\Models\Leaver\DAO\LeaverDAO;
use AC\Models\Leaver\DTO\LeaverDTO;
use Rakit\Validation\RuleQuashException;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class ApplyingService
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
    private LeaverDAO $leaverDAO;

    /**
     * @param LeaverDTO $dto
     * @return Validation
     * @throws ConfigFileNotFoundException
     * @throws InvalidConfigException
     * @throws RuleQuashException
     */
    public function validateConfigEmailLeaverPost(LeaverDTO $dto): Validation
    {
        $validation = $this->getLeaverConfigEmailValidation($dto);
        $validation->validate();

        return $validation;
    }

    /**
     * @param LeaverDTO $dto
     * @return Validation
     * @throws ConfigFileNotFoundException
     * @throws InvalidConfigException
     * @throws RuleQuashException
     */
    protected function getLeaverConfigEmailValidation(LeaverDTO $dto): Validation
    {
        $rules = $this->validationConfig->getValidationRules(
            ValidationConfigKeys::APPLYING_CONFIRM_EMAIL()
        );
        $messages = $this->validationConfig->getValidationMessages(
            ValidationConfigKeys::APPLYING_CONFIRM_EMAIL()
        );

        $fields = ['email' => $dto->email];

        $this->validator->addValidator('uniqueEmail', new UniqueEmailRule($this->leaverDAO));

        $validation = $this->validator->make($fields,$rules);

        $validation->setMessages($messages);

        return $validation;
    }
}