<?php

namespace App\Controller;

use App\Contract\Entity\Service\EmployeeService;
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

        if ($name !== null && !is_string($name)) {
            $name = null;
        }

        $data = $this->employeeService->get($page, $name);

        return $this->renderForm('employees.html.twig', [
            'data' => $data,
            'currentPage' => $page,
            'lastPage' => ceil($data->count / $data->limit),
            'chiefName' => $name
        ]);
    }
}
