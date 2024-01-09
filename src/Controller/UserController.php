<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Fidelite;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'admin', methods: ['GET'])]
    public function index(UserRepository $userRepository, Security $security): Response
    {
        $currentPage = 'Tableau de bord';
        $user = $security->getUser();


        if ($user instanceof User) {
            $greeting = 'Bonjour ' . $user->getNom() . ' ' . $user->getPrenom();
        } else {
            $greeting = 'Bonjour Visiteur !';
        }
        return $this->render('user/admin/admin.html.twig', [
            'currentPage' => $currentPage,
            'users' => $userRepository->findAll(),
            'greeting' => $greeting,
        ]);
    }
    #[Route('/user', name: 'admin_clients', methods: ['GET'])]
    public function clients(Request $request, UserRepository $userRepository, Security $security, PaginatorInterface $paginator): Response
    {
        $currentPage = 'Liste de clients RouenBio';
        $user = $security->getUser();


        $tri = $request->query->get('tri');
        $nomsTries = $userRepository->trierNoms();

        $triValide = ['nom', 'email', 'mt_fidelite', 'ville'];

        if (in_array($tri, $triValide)) {
            // Trie les utilisateurs en fonction de la valeur de tri
            $users = $userRepository->findBy([], [$tri => 'ASC']);
        } else {
            // Par défaut, récupère tous les utilisateurs
            $users = $userRepository->findAll();
        }

        if ($user instanceof User) {

            $greeting = 'Bonjour, ' . $user->getNom() . ' ' . $user->getPrenom();

            // Perform count operation
            $totalCount = $userRepository->count([]); // Count all users

            // Paginate the users
            $pageSize = 10; // Number of items per page
            $currentPages = $request->query->getInt('page', 1); // Get the current page from the request

            $pagination = $paginator->paginate(
                $users,
                $currentPages,
                $pageSize
            );

            $users = $pagination->getItems(); // Update $users with the paginated results
        } else {
            $greeting = 'Bonjour Visiteur !';
        }

        return $this->render('user/admin/index.html.twig', [
            'currentPage' => $currentPage,
            'users' => $users,
            'greeting' => $greeting,

            'nomsTries' => $nomsTries,
            'pagination' => $pagination, // Pass the pagination object to the template
        ]);
    }




    #[Route('/profile', name: 'profile', methods: ['GET'])]
    public function profile(Security $security): Response
    {

        $user = $security->getUser();
        $currentPage = 'Votre espace Bio';
        if ($user instanceof User) {
            // $greeting = 'Bonjour ' . $user->getNom() . ' ' . $user->getPrenom();
        }

        return $this->render('user/profile/index.html.twig', [
            'currentPage' => $currentPage,
            'user' => $user,
            // 'greeting' => $greeting,
        ]);
    }

    #[Route('/admin', name: 'profile_admin', methods: ['GET'])]
    public function profileAdmin(Security $security): Response
    {

        $user = $security->getUser();
        $currentPage = 'Tableau de bord';
        if ($user instanceof User) {
            // $greeting = 'Bonjour ' . $user->getNom() . ' ' . $user->getPrenom();
        }

        return $this->render('user/admin/profile_admin.html.twig', [
            'currentPage' => $currentPage,
            'user' => $user,
            // 'greeting' => $greeting,
        ]);
    }


    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        $currentPage = 'Utilisateurs RouenBio';
        $greeting = 'Bonjour ' . $user->getNom() . ' ' . $user->getPrenom();
        return $this->render('user/admin/show.html.twig', [
            'user' => $user,
            'currentPage' => $currentPage,
            'greeting' => $greeting,


        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        $greeting = 'Bonjour ' . $user->getNom() . ' ' . $user->getPrenom();
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('admin', [
                    'greeting' => $greeting,
                ], Response::HTTP_SEE_OTHER);
            } elseif ($this->isGranted('ROLE_USER')) {
                return $this->redirectToRoute('profile', [
                    'greeting' => $greeting,
                ], Response::HTTP_SEE_OTHER);
            }
        }
        $currentPage = 'Modification utilisateur';

        return $this->render('user/admin/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'currentPage' => $currentPage,
            'greeting' => $greeting,
        ]);
    }



    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }
}
