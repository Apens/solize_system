<?php

namespace App\Controller\Admin;

use App\Entity\ServiceJob;
use App\Form\ServiceJobType;
use App\Repository\ServiceJobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backoffice/service_job')]
class ServiceJobController extends AbstractController
{
    #[Route('/', name: 'service_job_index', methods: ['GET'])]
    public function index(ServiceJobRepository $serviceJobRepository): Response
    {
        return $this->render('admin/service_job/index.html.twig', [
            'service_jobs' => $serviceJobRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'service_job_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $serviceJob = new ServiceJob();
        $form = $this->createForm(ServiceJobType::class, $serviceJob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($serviceJob);
            $entityManager->flush();

            return $this->redirectToRoute('service_job_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/service_job/new.html.twig', [
            'service_job' => $serviceJob,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'service_job_show', methods: ['GET'])]
    public function show(ServiceJob $serviceJob): Response
    {
        return $this->render('admin/service_job/show.html.twig', [
            'service_job' => $serviceJob,
        ]);
    }

    #[Route('/{id}/edit', name: 'service_job_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServiceJob $serviceJob, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServiceJobType::class, $serviceJob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('service_job_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/service_job/edit.html.twig', [
            'service_job' => $serviceJob,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'service_job_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceJob $serviceJob, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serviceJob->getId(), $request->request->get('_token'))) {
            $entityManager->remove($serviceJob);
            $entityManager->flush();
        }

        return $this->redirectToRoute('service_job_index', [], Response::HTTP_SEE_OTHER);
    }
}
