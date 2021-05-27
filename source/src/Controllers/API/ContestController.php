<?php declare(strict_types=1);

namespace AC\Controllers\API;

use AC\Controllers\BaseController;
use AC\Controllers\Enum\StatusEnum;
use AC\Models\Contest\DAO\ContestDAO;
use AC\Models\Faculty\DAO\FacultyDAO;
use AC\Models\Leaver\DTO\LeaverDTO;
use AC\Models\Result\ResultDTO;
use AC\Models\Specialty\DTO\SpecialtyDTO;
use AC\Service\Http\Request;
use AC\Service\Http\Response;
use ParagonIE\EasyDB\Exception\MustBeNonEmpty;

/**
 * API Контроллер для работы с конкурсами
 *
 * Class ContestController
 * @package AC\Controllers\API
 */
class ContestController extends BaseController
{
    /**
     * @Inject
     * @var ContestDAO
     */
    private ContestDAO $contestDao;

    /**
     * @Inject
     * @var FacultyDAO
     */
    private FacultyDAO $facultyDao;

    /**
     * @param Response $response
     * @param Request $request
     */
    public function __construct(Response $response, Request $request)
    {
        parent::__construct($response, $request);
    }

    /**
     * Action-функция
     * Возвращает json доступных конкурсов
     *
     * @throws MustBeNonEmpty
     */
    public function getAvailableByLeaverAndSpeciality(): void
    {
        $leaverDto = LeaverDTO::fromRequest($this->getRequest());
        $specialityDto = SpecialtyDTO::fromRequest($this->getRequest());

        if (!$leaverDto->exams || !$leaverDto->urov || !$specialityDto->code) {
            $result = new ResultDTO(StatusEnum::FAILURE(), [], ['urov or exams parameter not found']);
        } else {
            $contestList = $this->contestDao->getByLeaverAndSection($leaverDto, $specialityDto);
            $facultyList = $this->facultyDao->getByIds(array_column($contestList, 'facultyCode'));
            $this->mergeFacultyToContestList($contestList, $facultyList);
            $result = new ResultDTO(StatusEnum::SUCCESS(), $contestList);
        }

        $this->getResponse()->toJson($result->toArray());
    }

    /**
     * Вспомогательная функция для слияния массивов конкурсов и факультетов
     *
     * @param array $contestList
     * @param array $facultyList
     */
    protected function mergeFacultyToContestList(array &$contestList, array $facultyList): void
    {
        foreach ($contestList as $contestKey => $contest) {
            foreach ($facultyList as $faculty) {
                if ($contest['facultyCode'] == $faculty['id']){
                    $contestList[$contestKey]['faculty'] = $faculty['name'];
                }
            }
        }
    }
}