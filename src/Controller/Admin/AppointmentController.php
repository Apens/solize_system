<?php

namespace App\Controller\Admin;

use App\Entity\Appointment;
use App\Entity\User;
use App\Form\AppointmentType;
use App\Repository\AppointmentRepository;
use App\Repository\UserRepository;
use ContainerRwgbiCs\getUserRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backoffice/appointment')]
class AppointmentController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
          $this->userRepository = $userRepository;
    }

    public function getLoggedUser( $data): User
    {
        $userLoggedIn = $data;
        return $this->userRepository->find($userLoggedIn);
    }

    #[Route('/', name: 'appointment_index', methods: ['GET'])]
    public function index(AppointmentRepository $appointmentRepository): Response
    {
        return $this->render('admin/appointment/index.html.twig', [
            'appointments' => $appointmentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'appointment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $appointment = new Appointment();

        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $this->getUser();
            $current_user =  $this->getLoggedUser($data);
            $current_date = new \DateTimeImmutable('now');

            $appointment->setCreatedAt($current_date);
            $appointment->setUserCreated($current_user);
            $entityManager->persist($appointment);
            $entityManager->flush();

            return $this->redirectToRoute('appointment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/appointment/new.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'appointment_show', methods: ['GET'])]
    public function show(Appointment $appointment): Response
    {
        $author = $appointment->getUserCreated()->getLastname();



        return $this->render('admin/appointment/show.html.twig', [
            'appointment' => $appointment,
            'author' => $author,
        ]);
    }

    #[Route('/{id}/edit', name: 'appointment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Appointment $appointment, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appointment->setUpdatedAt( new \DateTimeImmutable('now') );

            $entityManager->flush();

            return $this->redirectToRoute('appointment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/appointment/edit.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'appointment_delete', methods: ['POST'])]
    public function delete(Request $request, Appointment $appointment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appointment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($appointment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('appointment_index', [], Response::HTTP_SEE_OTHER);
    }
}
