<?php

namespace AC\Service\Leaver;

use AC\Config\Exceptions\ConfigFileNotFoundException;
use AC\Config\Exceptions\InvalidConfigException;
use AC\Config\Validation\Rules\Leaver\UniqueEmailRule;
use AC\Config\Validation\ValidationConfig;
use AC\Config\Validation\ValidationConfigKeys;
use AC\Models\Contest\DAO\ContestDAO;
use AC\Models\Contest\DTO\ContestDTO;
use AC\Models\File\DAO\FileDAO;
use AC\Models\File\DTO\FileDTO;
use AC\Models\Leaver\DAO\LeaverDAO;
use AC\Models\Leaver\DTO\LeaverDTO;
use AC\Models\Leaver\DTO\LeaverDTOCollection;
use AC\Models\Leaver\Exam\DAO\ExamDao;
use AC\Models\Leaver\Exam\DTO\LeaverExamDTOCollection;
use AC\Models\Leaver\IndividAchiev\DAO\IndividAchievDAO;
use AC\Models\Leaver\IndividAchiev\DTO\IndividAchievDTOCollection;
use AC\Models\Leaver\PreemRight\DAO\PreemRightDAO;
use AC\Models\Leaver\PreemRight\DTO\PreemRightDTOCollection;
use AC\Models\Leaver\Specials\DAO\SpecialsDao;
use AC\Models\Leaver\Specials\DTO\SpecialsDTOCollection;
use AC\Models\Leaver\SpecRight\DAO\SpecRightDAO;
use AC\Models\Leaver\SpecRight\DTO\SpecRightDTOCollection;
use Exception;
use Rakit\Validation\RuleQuashException;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;
use function DI\create;

/**
 * Сервис для валидации данных при подачи заявления
 *
 * Class ApplyingService
 * @package AC\Service\Leaver
 */
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
    private LeaverDAO $leaverDao;

    /**
     * @Inject
     * @var SpecRightDAO
     */
    private SpecRightDAO $specRightDAO;

    /**
     * @Inject
     * @var PreemRightDAO
     */
    private PreemRightDAO $preemRightDAO;

    /**
     * @Inject
     * @var IndividAchievDAO
     */
    private IndividAchievDAO $individAchievDAO;

    /**
     * @Inject
     * @var FileDAO
     */
    private FileDAO $fileDao;

    /**
     * @Inject
     * @var ExamDao
     */
    private ExamDao $examDao;

    /**
     * @Inject
     * @var SpecialsDao
     */
    private SpecialsDao $specialsDao;

    /**
     * @Inject
     * @var ContestDAO
     */
    private ContestDAO $contestDao;

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

        $this->validator->addValidator('uniqueEmail', new UniqueEmailRule($this->leaverDao));

        $validation = $this->validator->make($fields,$rules);

        $validation->setMessages($messages);

        return $validation;
    }

    /**
     * @param int|null $id
     * @return FileDTO|null
     */
    protected function getLeaverFile(?int $id): ?FileDTO
    {
        if (!$id) {
            return null;
        }

        return ($fileRes = $this->fileDao->getById($id))
            ? new FileDTO($fileRes)
            : null;
    }

    /**
     * @param LeaverDTO $dto
     */
    public function setLeaverFiles(LeaverDTO &$dto): void
    {
        $fieldsList = [
            'passportFileId' => 'passportFile',
            'educDocFileId' => 'educDocFile',
            'comDocFileId' => 'comDocFile'
        ];

        foreach ($fieldsList as $valueKey => $resultKey) {
            $dto->{$resultKey} = $this->getLeaverFile($dto->{$valueKey});
        }

        if ($dto->specRights) {
            foreach ($dto->specRights as $specRight) {
                $specRight->document = ($this->getLeaverFile($specRight->documentId));
            }
        }

        if ($dto->preemRights) {
            foreach ($dto->specRights as $specRight) {
                $specRight->document = ($this->getLeaverFile($specRight->documentId));
            }
        }

        if ($dto->individAchievs) {
            foreach ($dto->specRights as $specRight) {
                $specRight->document = ($this->getLeaverFile($specRight->documentId));
            }
        }

        if ($dto->specials) {
            foreach ($dto->specials as $special) {
                $special->targetDocFile = ($this->getLeaverFile($special->targetDocId));
            }
        }
    }

    public function setLeaverRights(LeaverDTO &$dto): void
    {
        $dto->specRights = ($specRights = $this->specRightDAO->getByLeaverId($dto->id))
            ? SpecRightDTOCollection::create($specRights)
            : null;

        $dto->preemRights = ($preemRights = $this->preemRightDAO->getByLeaverId($dto->id))
            ? PreemRightDTOCollection::create($preemRights)
            : null;

        $dto->individAchievs = ($individAchievs = $this->individAchievDAO->getByLeaverId($dto->id))
            ? IndividAchievDTOCollection::create($individAchievs)
            : null;
    }

    public function setChildrenDtoLeaverId(LeaverDTO &$dto): void
    {
        $fileList = [
          'passportFile', 'educDocFile', 'correctInfoFile'
        ];

        /**
         * @var FileDTO $dto->{$resultKey}
         */
        foreach ($fileList as $fileKey) {
            $dto->{$fileKey}->leaverId = $dto->id;
        }

        if ($dto->specRights) {
            foreach ($dto->specRights as $specRight) {
                $specRight->leaverId = $dto->id;
                if ($specRight->document) {
                    $specRight->document->leaverId = $dto->id;
                }
            }
        }

        if ($dto->preemRights) {
            foreach ($dto->preemRights as $preemRight) {
                $preemRight->leaverId = $dto->id;
                if ($preemRight->document) {
                    $preemRight->document->leaverId = $dto->id;
                }
            }
        }

        if ($dto->individAchievs) {
            foreach ($dto->individAchievs as $individAchiev) {
                $individAchiev->leaverId = $dto->id;
                if ($individAchiev->document) {
                    $individAchiev->document->leaverId = $dto->id;
                }
            }
        }

        if ($dto->specials) {
            foreach ($dto->specials as $special) {
                $special->leaverId = $dto->id;
                if ($special->targetDocFile) {
                    $special->targetDocFile->leaverId = $dto->id;
                }
            }
        }

        if ($dto->exams) {
            foreach ($dto->exams as $exam) {
                $exam->leaverId = $dto->id;
            }
        }
    }

    /**
     * @param LeaverDTO $dto
     * @throws Exception
     */
    public function addLeaverFiles(LeaverDTO &$dto): void
    {
        $fieldsList = [
            'passportFileId' => 'passportFile',
            'educDocFileId' => 'educDocFile',
            'correctInfoFileId' => 'correctInfoFile'
        ];

        /**
         * @var FileDTO $dto->{$resultKey}
         */
        foreach ($fieldsList as $valueKey => $resultKey) {
            if ($dto->{$resultKey}) {
                $dto->{$valueKey} = $this->fileDao->add($dto->{$resultKey});
            }
        }

        if ($dto->specRights) {
            foreach ($dto->specRights as $specRight) {
                if ($specRight->document) {
                    $specRight->documentId = $this->fileDao->add($specRight->document);
                }
            }
        }

        if ($dto->preemRights) {
            foreach ($dto->preemRights as $preemRight) {
                if ($preemRight->document) {
                    $preemRight->documentId = $this->fileDao->add($preemRight->document);
                }
            }
        }

        if ($dto->individAchievs) {
            foreach ($dto->individAchievs as $individAchiev) {
                if ($individAchiev->document) {
                    $individAchiev->documentId = $this->fileDao->add($individAchiev->document);
                }
            }
        }

        if ($dto->specials) {
            foreach ($dto->specials as $special) {
                if ($special->targetDocFile) {
                    $special->targetDocId = $this->fileDao->add($special->targetDocFile);
                }
            }
        }
    }

    /**
     * @param LeaverDTO $dto
     * @throws Exception
     */
    public function addChildrenDto(LeaverDTO $dto)
    {
        if ($dto->exams) {
            $this->examDao->addMore($dto->exams);
        }
        if ($dto->specRights) {
            $this->specRightDAO->addMore($dto->specRights);
        }
        if ($dto->preemRights) {
            $this->preemRightDAO->addMore($dto->preemRights);
        }
        if ($dto->individAchievs) {
            $this->individAchievDAO->addMore($dto->individAchievs);
        }
        if ($dto->specials) {
            $this->specialsDao->addMore($dto->specials);
        }
    }

    public function setChildrenDto(LeaverDTO &$dto)
    {
        if (!$dto->exams) {
            $dto->exams = ($examsRes = $this->examDao->getByLeaverId($dto->id))
                ? LeaverExamDTOCollection::create($examsRes)
                : null;
        }
        if (!$dto->specRights) {
            $dto->specRights = ($specRightsRes = $this->specRightDAO->getByLeaverId($dto->id))
                ? SpecRightDTOCollection::create($specRightsRes)
                : null;
        }
        if (!$dto->preemRights) {
            $dto->preemRights = ($preemRightsRes = $this->preemRightDAO->getByLeaverId($dto->id))
                ? PreemRightDTOCollection::create($preemRightsRes)
                : null;
        }
        if (!$dto->individAchievs) {
            $dto->individAchievs = ($individAchievsRes = $this->individAchievDAO->getByLeaverId($dto->id))
                ? IndividAchievDTOCollection::create($individAchievsRes)
                : null;
        }
        if (!$dto->specials) {
            $dto->specials = ($specialsRes = $this->specialsDao->getByLeaverId($dto->id))
                ? SpecialsDTOCollection::create($specialsRes)
                : null;
            if ($dto->specials === null) return;
            foreach ($dto->specials as $special) {

                  $special->contest = ($special->idContest) ?  $this->contestDao->getById($special->idContest) : null;
                  if ($special->contest)
                      $special->contest = $special->contest[0];
            }
        }
    }

    /**
     * @param int $id
     * @return LeaverDTO|null
     */
    public function getLeaverAllById(int $id): ?LeaverDTO
    {
        $leaver = ($leaverRes = $this->leaverDao->getById($id))
            ? new LeaverDTO($leaverRes) : null;

        if (!$leaver) {
            return null;
        }

        $this->setChildrenDto($leaver);
        $this->setLeaverFiles($leaver);

        return $leaver;
    }

    /**
     * @param LeaverDTO|null $leaver
     * @return void
     */
    public function getChildrenAndFilesByLeaver(?LeaverDTO &$leaver)
    {
        if (!$leaver) {
            return null;
        }

        $this->setChildrenDto($leaver);
        $this->setLeaverFiles($leaver);
    }

    /**
     * @return LeaverDTOCollection|null
     */
    public function getAllLeavers(): ?LeaverDTOCollection
    {
        return ($leaversRes = $this->leaverDao->getAll())
            ? LeaverDTOCollection::create($leaversRes)
            : null;
    }
}