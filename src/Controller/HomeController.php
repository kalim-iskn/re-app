<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index()
    {
        return $this->render('home.html.twig', [
            'employeeUploadFileLink' => $this->generateUrl('file_upload'),
            'employeesListLink' => $this->generateUrl('employees_list')
        ]);
    }
}
