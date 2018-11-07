<?php

namespace App\Controller;

use App\Entity\RolesUsers;
use App\Form\RolesUsersType;
use App\Repository\RolesUsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/roles/users")
 */
class RolesUsersController extends AbstractController
{
    /**
     * @Route("/", name="roles_users_index", methods="GET")
     */
    public function index(RolesUsersRepository $rolesUsersRepository): Response
    {
        return $this->render('roles_users/index.html.twig', ['roles_users' => $rolesUsersRepository->findAll()]);
    }

    /**
     * @Route("/new", name="roles_users_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $rolesUser = new RolesUsers();
        $form = $this->createForm(RolesUsersType::class, $rolesUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rolesUser);
            $em->flush();

            return $this->redirectToRoute('roles_users_index');
        }

        return $this->render('roles_users/new.html.twig', [
            'roles_user' => $rolesUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="roles_users_show", methods="GET")
     */
    public function show(RolesUsers $rolesUser): Response
    {
        return $this->render('roles_users/show.html.twig', ['roles_user' => $rolesUser]);
    }

    /**
     * @Route("/{id}/edit", name="roles_users_edit", methods="GET|POST")
     */
    public function edit(Request $request, RolesUsers $rolesUser): Response
    {
        $form = $this->createForm(RolesUsersType::class, $rolesUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('roles_users_index', ['id' => $rolesUser->getId()]);
        }

        return $this->render('roles_users/edit.html.twig', [
            'roles_user' => $rolesUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="roles_users_delete", methods="DELETE")
     */
    public function delete(Request $request, RolesUsers $rolesUser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rolesUser->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rolesUser);
            $em->flush();
        }

        return $this->redirectToRoute('roles_users_index');
    }
}
