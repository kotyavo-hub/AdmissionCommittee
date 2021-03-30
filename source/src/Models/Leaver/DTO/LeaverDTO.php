<?php

namespace AC\Models\Leaver\DTO;

use AC\Service\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

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

    public ?string $passportFile;

    public ?float $passportFileSize;

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

    public ?string $graduateYear;

    public ?string $education;

    public ?string $lang;

    public ?int $educDocTypeCode;

    public ?string $educDocSeria;

    public ?string $educDocNo;

    public ?string $educDocDate;

    public ?string $educDocDistr;

    public ?int $educDocSelf;

    public ?int $educDocOriginal;

    public ?string $educDocOriginalDate;

    public ?string $supplementNo;

    public ?string $supplementSeria;

    public ?string $sCountry;

    public ?string $sAddress;

    public ?int $attres3;

    public ?int $attres4;

    public ?int $attres5;

    public ?string $educDocFile;

    public ?float $educDocFileSize;

    public ?int $priorityVUZ;

    public ?int $countVUZ;

    public ?int $needHostel;

    public ?string $prestart;

    public ?string $comDocType;

    public ?string $comDocSeria;

    public ?string $comDocNo;

    public ?string $comDocDate;

    public ?string $comDocDistr;

    public ?string $comDocFile;

    public ?float $comDocFileSize;

    public ?int $statusEmail;

    public ?int $statusComplete;

    public static function fromRequest(Request $request): self
    {
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
            'passportFile' => trim($request->getParamFromPostVar('passportFile')),
            'passportFileSize' => (double)trim($request->getParamFromPostVar('passportFileSize')),
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
            'graduateYear' => trim($request->getParamFromPostVar('graduateYear')),
            'education' => trim($request->getParamFromPostVar('education')),
            'lang' => trim($request->getParamFromPostVar('lang')),
            'educDocTypeCode' => (int)trim($request->getParamFromPostVar('educDocTypeCode')),
            'educDocSeria' => trim($request->getParamFromPostVar('educDocSeria')),
            'educDocNo' => trim($request->getParamFromPostVar('educDocNo')),
            'educDocDate' => trim($request->getParamFromPostVar('educDocDate')),
            'educDocDistr' => trim($request->getParamFromPostVar('educDocDistr')),
            'educDocSelf' => (int)trim($request->getParamFromPostVar('educDocSelf')),
            'educDocOriginal' => (int)trim($request->getParamFromPostVar('educDocOriginal')),
            'educDocOriginalDate' => trim($request->getParamFromPostVar('educDocOriginalDate')),
            'supplementNo' => trim($request->getParamFromPostVar('supplementNo')),
            'supplementSeria' => trim($request->getParamFromPostVar('supplementSeria')),
            'sCountry' => trim($request->getParamFromPostVar('sCountry')),
            'sAddress' => trim($request->getParamFromPostVar('sAddress')),
            'attres3' => (int)trim($request->getParamFromPostVar('attres3')),
            'attres4' => (int)trim($request->getParamFromPostVar('attres4')),
            'attres5' => (int)trim($request->getParamFromPostVar('attres5')),
            'educDocFile' => trim($request->getParamFromPostVar('educDocFile')),
            'educDocFileSize' => (double)trim($request->getParamFromPostVar('educDocFileSize')),
            'priorityVUZ' => (int)trim($request->getParamFromPostVar('priorityVUZ')),
            'countVUZ' => (int)trim($request->getParamFromPostVar('countVUZ')),
            'needHostel' => (int)trim($request->getParamFromPostVar('needHostel')),
            'prestart' => trim($request->getParamFromPostVar('prestart')),
            'comDocType' => trim($request->getParamFromPostVar('comDocType')),
            'comDocSeria' => trim($request->getParamFromPostVar('comDocSeria')),
            'comDocNo' => trim($request->getParamFromPostVar('comDocNo')),
            'comDocDate' => trim($request->getParamFromPostVar('comDocDate')),
            'comDocDistr' => trim($request->getParamFromPostVar('comDocDistr')),
            'comDocFile' => trim($request->getParamFromPostVar('comDocFile')),
            'comDocFileSize' => (double)trim($request->getParamFromPostVar('comDocFileSize')),
            'statusEmail' => (int)trim($request->getParamFromPostVar('statusEmail')),
            'statusComplete' => (int)trim($request->getParamFromPostVar('statusComplete'))
        ]);
    }
}