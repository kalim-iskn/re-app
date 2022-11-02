<?php

namespace App\Service\Entity;

use App\Contract\Entity\Repository\EmployeeRepository;
use App\Contract\Entity\Service\EmployeeService;
use App\DTO\Entity\EmployeeDTO;
use App\DTO\Entity\EmployeesPaginationDTO;
use App\Exception\EntityNotFoundException;
use Exception;
use Psr\Log\LoggerInterface;

class EmployeeServiceImpl implements EmployeeService
{
    protected EmployeeRepository $employeeRepository;
    protected LoggerInterface $logger;

    public function __construct(EmployeeRepository $employeeRepository, LoggerInterface $logger)
    {
        $this->employeeRepository = $employeeRepository;
        $this->logger = $logger;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function storeByNames(array $employeesFileLines): void
    {
        $employees = [];

        foreach ($employeesFileLines as $employeesFileLine) {
            $employee = new EmployeeDTO();
            $employee->name = trim($employeesFileLine->employeeName);

            if ($employeesFileLine->chiefName !== null) {
                $employee->chief = $this->employeeRepository->getByName(trim($employeesFileLine->chiefName));
            }
            $employees[] = $employee;
        }

        $this->employeeRepository->saveMany($employees);
    }

    /**
     * @throws Exception
     */
    public function get(int $page, ?string $chiefName = null): EmployeesPaginationDTO
    {
        if ($page < 1) {
            throw new Exception("page invalid");
        }

        $arDto = $this->employeeRepository->paginate(
            ($page - 1) * EmployeeRepository::PAGINATE_LIMIT,
            $chiefName
        );
        $count = $this->employeeRepository->countAll();

        $paginationDto = new EmployeesPaginationDTO();
        $paginationDto->items = $arDto;
        $paginationDto->count = $count;

        return $paginationDto;
    }
}
