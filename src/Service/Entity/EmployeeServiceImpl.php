<?php

namespace App\Service\Entity;

use App\Contract\Entity\Repository\EmployeeRepository;
use App\Contract\Entity\Service\EmployeeService;
use App\Exception\EntityNotFoundException;
use EmployeeDTO;
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
}
