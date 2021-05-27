<?php

namespace AC\Models\Leaver\DTO;

use AC\Models\Contest\DTO\ContestDTOCollection;
use AC\Models\Leaver\Exam\DTO\LeaverExamDTOCollection;
use AC\Models\File\DTO\FileDTO;
use AC\Models\Leaver\IndividAchiev\DTO\IndividAchievDTOCollection;
use AC\Models\Leaver\PreemRight\DTO\PreemRightDTOCollection;
use AC\Models\Leaver\Specials\DTO\SpecialsDTOCollection;
use AC\Models\Leaver\SpecRight\DTO\SpecRightDTOCollection;
use AC\Service\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Класс DTO для работы с данными заявлений
 *
 * Class LeaverDTO
 * @package AC\Models\Leaver\DTO
 */
class LeaverDTO extends DataTransferObject
{
    public ?int $id;

    public ?string $guid;

    public ?string $surName;

    public ?string $name;

    public ?string $middleName;

    public ?string $gender;

    public ?string $citizenCode;

    public ?string $givingDate;

    public ?int $docTypeId;

    public ?string $docSeria;

    public ?string $docNo;

    public ?string $docDate;

    public ?string $docDistr;

    public ?string $docFMSCode;

    public ?string $bornDate;

    public ?int $passportFileId;

    public ?FileDTO $passportFile;

    public ?string $bCountry;

    public ?string $bAddress;

    public ?string $rCountry;

    public ?string $rAddress;

    public ?string $fCountry;

    public ?string $fAddress;

    public ?string $hometel;

    public ?string $mobtel;

    public ?string $email;

    public ?string $schoolTypeCode;

    public ?string $schoolNumber;

    public ?int $graduateYear;

    public ?string $education;

    public ?string $lang;

    public ?int $educDocTypeCode;

    public ?string $educDocSeria;

    public ?string $educDocNo;

    public ?string $educDocDate;

    public ?string $educDocDistr;

    public ?string $supplementNo;

    public ?string $supplementSeria;

    public ?string $sCountry;

    public ?string $sAddress;

    public ?int $attres3;

    public ?int $attres4;

    public ?int $attres5;

    public ?int $educDocFileId;

    public ?FileDTO $educDocFile;

    public ?int $priorityVUZ;

    public ?int $countVUZ;

    public ?int $needHostel;

    public ?string $prestart;

    public ?int $statusEmail;

    public ?int $statusComplete;

    public ?LeaverExamDTOCollection $exams;

    public ?SpecRightDTOCollection $specRights;

    public ?PreemRightDTOCollection $preemRights;

    public ?IndividAchievDTOCollection $individAchievs;

    public ?int $urov;

    public ?int $useSpecRight;

    public ?int $correctInfoFileId;

    public ?FileDTO $correctInfoFile;

    public ?SpecialsDTOCollection $specials;

    /**
     * Функция для получения данных из Request
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): self
    {
        $examsInputArrayParams = [
            'examId' => FILTER_VALIDATE_INT,
            'result' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['default' => 0]
            ],
            'passingLeaverTests' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['default' => 0]
            ]
        ];

        $preemRightsInputArrayParam = [
            'docType' => FILTER_VALIDATE_INT,
            'docSeria' => FILTER_VALIDATE_INT,
            'docNumber' => FILTER_VALIDATE_INT,
            'docDate' => FILTER_SANITIZE_STRING,
            'docOrganization' => FILTER_SANITIZE_STRING,
        ];

        $specialsRightsInputArrayParam = [
            'idContest' => FILTER_VALIDATE_INT,
            'planInternalCommerce' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['default' => 0]
            ],
            'planExternalCommerce' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['default' => 0]
            ],
            'planIECommerce' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['default' => 0]
            ],
            'planInternalQuotas' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['default' => 0]
            ],
            'planExternalQuotas' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['default' => 0]
            ],
            'planIEQuotas' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['default' => 0]
            ],
            'planInternalTarget' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['default' => 0]
            ],
            'planExternalTarget' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['default' => 0]
            ],
            'planIETarget' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['default' => 0]
            ],
            'planInternal' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['default' => 0]
            ],
            'planExternal' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['default' => 0]
            ],
            'planIE' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['default' => 0]
            ]
        ];

        return new self([
            'id' => (int)trim($request->getParamFromPostVar('id')),
            'guid' => trim($request->getParamFromPostVar('guid')),
            'surName' => trim($request->getParamFromPostVar('surName')),
            'name' => trim($request->getParamFromPostVar('name')),
            'middleName' => trim($request->getParamFromPostVar('middleName')),
            'gender' => trim($request->getParamFromPostVar('gender')),
            'citizenCode' => trim($request->getParamFromPostVar('citizenCode')),
            'givingDate' => trim($request->getParamFromPostVar('givingDate')),
            'docTypeId' => (int)trim($request->getParamFromPostVar('docTypeId')),
            'docSeria' => trim($request->getParamFromPostVar('docSeria')),
            'docNo' => trim($request->getParamFromPostVar('docNo')),
            'docDate' => trim($request->getParamFromPostVar('docDate')),
            'docDistr' => trim($request->getParamFromPostVar('docDistr')),
            'docFMSCode' => trim($request->getParamFromPostVar('docFMSCode')),
            'bornDate' => trim($request->getParamFromPostVar('bornDate')),
            'passportFile' => ($passportFile = $request->getFileFromPostVar('passportFile'))
                ? FileDTO::fromRequestFile($passportFile) : null,
            'bCountry' => trim($request->getParamFromPostVar('bCountry')),
            'bAddress' => trim($request->getParamFromPostVar('bAddress')),
            'rCountry' => trim($request->getParamFromPostVar('rCountry')),
            'rAddress' => trim($request->getParamFromPostVar('rAddress')),
            'fCountry' => trim($request->getParamFromPostVar('fCountry')),
            'fAddress' => trim($request->getParamFromPostVar('fAddress')),
            'hometel' => trim($request->getParamFromPostVar('hometel')),
            'mobtel' => trim($request->getParamFromPostVar('mobtel')),
            'email' => trim($request->getParamFromPostVar('email')),
            'schoolTypeCode' => trim($request->getParamFromPostVar('schoolTypeCode')),
            'schoolNumber' => trim($request->getParamFromPostVar('schoolNumber')),
            'graduateYear' => (int)trim($request->getParamFromPostVar('graduateYear')),
            'education' => trim($request->getParamFromPostVar('education')),
            'lang' => trim($request->getParamFromPostVar('lang')),
            'educDocTypeCode' => (int)trim($request->getParamFromPostVar('educDocTypeCode')),
            'educDocSeria' => trim($request->getParamFromPostVar('educDocSeria')),
            'educDocNo' => trim($request->getParamFromPostVar('educDocNo')),
            'educDocDate' => trim($request->getParamFromPostVar('educDocDate')),
            'educDocDistr' => trim($request->getParamFromPostVar('educDocDistr')),
            'supplementNo' => trim($request->getParamFromPostVar('supplementNo')),
            'supplementSeria' => trim($request->getParamFromPostVar('supplementSeria')),
            'sCountry' => trim($request->getParamFromPostVar('sCountry')),
            'sAddress' => trim($request->getParamFromPostVar('sAddress')),
            'attres3' => (int)trim($request->getParamFromPostVar('attres3')),
            'attres4' => (int)trim($request->getParamFromPostVar('attres4')),
            'attres5' => (int)trim($request->getParamFromPostVar('attres5')),
            'educDocFile' => ($passportFile = $request->getFileFromPostVar('educDocFile'))
                ? FileDTO::fromRequestFile($passportFile) : null,
            'priorityVUZ' => (int)trim($request->getParamFromPostVar('priorityVUZ')),
            'countVUZ' => (int)trim($request->getParamFromPostVar('countVUZ')),
            'needHostel' => (int)trim($request->getParamFromPostVar('needHostel')),
            'prestart' => trim($request->getParamFromPostVar('prestart')),
            'statusEmail' => (int)trim($request->getParamFromPostVar('statusEmail')),
            'statusComplete' => (int)trim($request->getParamFromPostVar('statusComplete')),
            'exams' => ($exam = $request->getParamFromPostVar('exams'))
                ? array_map(function ($value) use ($examsInputArrayParams) {
                    return filter_var_array($value, $examsInputArrayParams);
                  }, $exam)
                : null,
            'correctInfoFile' => ($correctInfoFile = $request->getFileFromPostVar('correctInfoFile'))
                ? FileDTO::fromRequestFile($correctInfoFile) : null,
            'urov' => (int)trim($request->getParamFromPostVar('urov')),
            'useSpecRight' => (int)trim($request->getParamFromPostVar('useSpecRight')),
            'specRights' => (
                ($specRights = $request->getParamFromPostVar('specRights')) &&
                (bool)$request->getParamFromPostVar('toggleSpecRights')
            ) ? SpecRightDTOCollection::create(self::mergePostFiles(
                'specRights',
                'document',
                $specRights,
                $request->getFileFromPostVar('specRights')
            ))
            : null,
            'preemRights' => (
                ($preemRights = $request->getParamFromPostVar('preemRights')) &&
                (bool)$request->getParamFromPostVar('togglePreemRights')
            ) ? PreemRightDTOCollection::create(self::mergePostFiles(
                    'preemRights',
                    'document',
                    array_map(function ($value) use ($preemRightsInputArrayParam) {
                        return filter_var_array($value, $preemRightsInputArrayParam, false);
                    }, $preemRights),
                    $request->getFileFromPostVar('preemRights')
                ))
            : null,
            'individAchievs' => (
                ($individAchievs = $request->getParamFromPostVar('individAchievs')) &&
                (bool)$request->getParamFromPostVar('toggleIndividAchievs')
            ) ? IndividAchievDTOCollection::create(self::mergePostFiles(
                'individAchievs',
                'document',
                array_map(function ($value) use ($preemRightsInputArrayParam) {
                    return filter_var_array($value, $preemRightsInputArrayParam, false);
                }, $individAchievs),
                $request->getFileFromPostVar('individAchievs')
            )) : null,
            'specials' => (
                ($specials = $request->getParamFromPostVar('specials'))
            ) ? SpecialsDTOCollection::create(self::mergePostFiles(
                'specials',
                'targetDocFile',
                array_map(function ($value) use ($specialsRightsInputArrayParam) {
                    return filter_var_array($value, $specialsRightsInputArrayParam, false);
                }, $specials),
                $request->getFileFromPostVar('specials')
            )) : null,
        ]);
    }

    protected static function mergePostFiles(string $name, string $fileKey, ?array $post, ?array $files)
    {
        if (!$post) {
            return null;
        }

        foreach ($post as $key => $item) {
            $post[$key][$fileKey] = ($file = $files[$key][$fileKey])
                ? FileDTO::fromRequestFile($file) : null;
        }

        return $post;
    }
}