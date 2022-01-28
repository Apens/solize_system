<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackofficeController extends AbstractController
{
    #[Route('/backoffice', name: 'admin_backoffice')]
    public function index(): Response
    {
        return $this->render('admin/backoffice/index.html.twig', [
            'controller_name' => 'BackofficeController',
        ]);
    }
}
