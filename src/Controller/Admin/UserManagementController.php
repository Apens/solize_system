<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserPasswordType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backoffice')]
class UserManagementController extends AbstractController
{
    private $entityManager;
    private $userRepository;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->entityManager = $manager;
        $this->userRepository = $manager->getRepository('App:User');
    }

    public function getMyUser($id)
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        return $user;
    }

    #[Route('/users', name: 'admin_user_list')]
    public function index(): Response
    {

        $users = $this->userRepository->findAll();

        return $this->render('admin/user_management/userlist.html.twig', [
            'users' => $users,
        ]);
    }
/*
    #[Route('/new_user', name: 'admin_user_new', methods: ['GET', 'POST'])]
    public function adminNewUser(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
*/
    #[Route('/user-profile/{id}', name: 'admin_show_user')]
    public function adminShowUser($id): Response
    {
        $user = $this->getMyUser($id);
        $user_company = $user->getUserCompany();

        return $this->render('admin/user_management/admin_user_profile.html.twig',[
            'user' => $user,
            'user_company'=> $user_company,
        ]);
    }

    #[Route('/edit-user/{id}', name: 'admin_edit_user', requirements: ['id'=>'\d+'], methods: ['GET','POST'])]
    public function adminUserEdit(int $id, Request $request, User $user): Response
    {
        $user = $this->getMyUser($id);

        $form= $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_user_list');
        }

        $password_form = $this->createForm(UserPasswordType::class, $user);
        $password_form->handleRequest($request);

        if ($password_form->isSubmitted() && $password_form->isValid()){
            $this->entityManager->flush();

            $this->addFlash('adminUserPassword', 'Le mot de passe de l\'utilisateur a bien été modifié');

            return $this->redirectToRoute('admin_user_list');
        }

        return $this->renderForm('admin/user_management/admin_user_edit.html.twig',[
            'user' => $user,
            'form' => $form,
            'password_form' => $password_form
        ]);
    }

    #[Route('/delete-user/{id}', name:'admin_delete_user')]
    public function adminDeleteUser(int $id): Response
    {
        $user = $this->getMyUser($id);

        $manager = $this->entityManager;

        $manager->remove($user);
        $manager->flush();
        $this->addFlash('deleteUser', 'L\'utilisateur à bien été supprimé');

        return $this->redirectToRoute('admin_user_list');
    }
}
