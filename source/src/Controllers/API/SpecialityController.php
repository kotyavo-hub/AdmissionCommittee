<?php declare(strict_types=1);

namespace AC\Controllers\API;

use AC\Controllers\API\Exceptions\NotFoundRequiredUrovOrExamsParamsException;
use AC\Controllers\BaseController;
use AC\Controllers\Enum\StatusEnum;
use AC\Models\Contest\DAO\ContestDAO;
use AC\Models\Leaver\DTO\LeaverDTO;
use AC\Models\Result\ResultDTO;
use AC\Models\Specialty\DAO\SpecialtyDAO;
use AC\Service\Http\Request;
use AC\Service\Http\Response;
use ParagonIE\EasyDB\Exception\MustBeNonEmpty;

class SpecialityController extends BaseController
{
    /**
     * @Inject
     * @var SpecialtyDAO
     */
    private SpecialtyDAO $specialtyDao;

    /**
     * @param Response $response
     * @param Request $request
     */
    public function __construct(Response $response, Request $request)
    {
        parent::__construct($response, $request);
    }

    /**
     * @throws MustBeNonEmpty
     */
    public function getSpecialtiesAvailableByLeaver()
    {
        $leaverDto = LeaverDTO::fromRequest($this->getRequest());

        if (!$leaverDto->exams || !$leaverDto->urov) {
            $result = new ResultDTO(StatusEnum::FAILURE(), [], ['urov or exams parameter not found']);
        } else {
            $specialList = $this->specialtyDao->getAvailableByLeaver($leaverDto);
            $result = new ResultDTO(StatusEnum::SUCCESS(), $specialList);
        }

        $this->getResponse()->toJson($result->toArray());
    }
}