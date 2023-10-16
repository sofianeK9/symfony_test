<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Genre;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class TestController extends AbstractController
{
    #[Route('/index', name: 'app_test_index')]
    public function user(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $userRepository = $em->getRepository(User::class);

        // liste des users triés par email
        $users = $userRepository->findAllUsersOrderedByMail();

        // user dont l'id est 1
        $user1 = $userRepository->find(1);

        // email = foo.foo@exemple.com

        $email = $userRepository->whereEmailIsFooFoo('foo.foo@exemple.com');

        // liste dont le user à le role USER

        $userRoles = $userRepository->WhereUserGetRolesUser('ROLE_USER');

        // user incatif

        $userInactif = $userRepository->inactifUser(false);

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'title' => 'Requete de lecture pour la partie User',
            'users' => $users,
            'user1' => $user1,
            'email' => $email,
            'userRoles' => $userRoles,
            'inactifUser' => $userInactif,
        ]);
    }

    #[Route('/livre', name: 'app_test_livre')]
    public function livre(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $livreRepository = $em->getRepository(Livre::class);
        $auteurRepository = $em->getRepository(Auteur::class);
        $genreRepositoru = $em->getRepository(Genre::class);


        // - la liste complète de tous les livres, triée par ordre alphabétique de titre

        $livresAll = $livreRepository->findAllBooks();

        // - l'unique livre dont l'id est `1`

        $livre1 = $livreRepository->find(1);

        // - la liste des livres dont le titre contient le mot clé `lorem`, triée par ordre alphabétique de titre

        $findTitle = $livreRepository->findTitle('%lorem%');

        // - la liste des livres dont l'id de l'auteur est `2`, triée par ordre alphabétique de titre

        $user2Books = $livreRepository->findBy([
            'auteur' => 2,
        ], [
            'titre' => 'ASC',
        ]);

        // - la liste des livres dont le genre contient le mot clé `roman`, triée par ordre alphabétique de titre

        $findGenre = $livreRepository->findGenreName('roman');


        return $this->render('test/livre.html.twig', [
            'test' => 'message livre test',
            'livresAll' => $livresAll,
            'livre1' => $livre1,
            'findTitle' => $findTitle,
            'user2Books' => $user2Books,
            'findGenre' => $findGenre,
        ]);
    }
}
