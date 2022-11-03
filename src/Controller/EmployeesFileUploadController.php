<?php

namespace App\Controller;

use App\Contract\Entity\Service\FileUploadService;
use App\DTO\Form\EmployeesFileUploadFormDTO;
use App\Form\EmployeesFileUploadType;
use App\Contract\EmployeesImportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class EmployeesFileUploadController extends AbstractController
{
    protected EmployeesImportService $employeesImportService;
    protected FileUploadService $fileUploadService;

    public function __construct(EmployeesImportService $employeesImportService, FileUploadService $fileUploadService)
    {
        $this->employeesImportService = $employeesImportService;
        $this->fileUploadService = $fileUploadService;
    }

    public function upload(Request $request)
    {
        $fileUploadDto = new EmployeesFileUploadFormDTO();
        $form = $this->createForm(EmployeesFileUploadType::class, $fileUploadDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileUploadId = $this->employeesImportService->import($fileUploadDto->getFile());
            return $this->redirectToRoute('file_check_status', ['id' => $fileUploadId]);
        }

        return $this->renderForm('upload-employees.html.twig', [
            'form' => $form,
        ]);
    }

    public function checkStatus(int $id)
    {
        $dto = $this->fileUploadService->getById($id);

        return $this->render('file-status.html.twig', [
            'fileInfo' => $dto
        ]);
    }
}
