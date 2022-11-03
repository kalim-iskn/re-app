<?php

namespace App\Controller;

use App\Contract\Entity\Service\EmployeeService;
use App\DTO\Entity\EmployeesPaginationDTO;
use App\Exception\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class EmployeeController extends AbstractController
{
    protected EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index(Request $request)
    {
        $page = $request->query->getInt('page', 1);
        $name = $request->get('chiefName');

        if (($name !== null && !is_string($name)) || empty($name)) {
            $name = null;
        }

        try {
            $data = $this->employeeService->get($page, $name);
            $error = null;
        } catch (EntityNotFoundException) {
            $data = new EmployeesPaginationDTO();
            $error = "Работник с указанным именем не существует";
        }

        $currentPageLink = $this->getPaginationUrl($page, $name);
        $previousPageLink = $this->getPaginationUrl($page - 1, $name);
        $nextPageLink = $this->getPaginationUrl($page + 1, $name);

        return $this->render('employees.html.twig', [
            'data' => $data,
            'currentPage' => $page,
            'lastPage' => ceil($data->count / $data->limit),
            'chiefName' => $name,
            'currentPageLink' => $currentPageLink,
            'previousPageLink' => $previousPageLink,
            'nextPageLink' => $nextPageLink,
            'error' => $error
        ]);
    }

    protected function getPaginationUrl(int $page, ?string $name = null): string
    {
        $params['page'] = $page;

        if ($name !== null) {
            $params['chiefName'] = $name;
        }

        return $this->generateUrl('employees_list', $params);
    }
}
