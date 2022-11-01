<?php

namespace App\Controller;

use App\DTO\Form\EmployeesFileUploadDTO;
use App\Form\EmployeesFileUploadType;
use App\Contract\EmployeesImportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeesFileUploadController extends AbstractController
{
    protected EmployeesImportService $employeesImportService;

    public function __construct(EmployeesImportService $employeesImportService)
    {
        $this->employeesImportService = $employeesImportService;
    }

    public function upload(Request $request)
    {
        $fileUploadDto = new EmployeesFileUploadDTO();
        $form = $this->createForm(EmployeesFileUploadType::class, $fileUploadDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->employeesImportService->import($fileUploadDto->getFile());
            return new Response("test");
        }

        return $this->renderForm('upload-employees.html.twig', [
            'form' => $form,
        ]);
    }
}
