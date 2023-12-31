<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Emprunteur;
use App\Entity\Emprunt;
use DateTime;
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

        // Requêtes de création :
        $auteur2 = $auteurRepository->find(2);
        $genre = $genreRepositoru->find(6);

        $newBook = new Livre();
        $newBook->setTitre('Totym autem externum');
        $newBook->setAnneeEdition(2020);
        $newBook->setNombrePages(300);
        $newBook->setCodeIsbn(9790412882714);
        $newBook->setAuteur($auteur2);
        $newBook->addGenre($genre);
        $em->persist($newBook);
        $em->flush();

        // Requêtes de mise à jour :

        $bookId2 = $livreRepository->find(2);
        $genreid5 = $genreRepositoru->find(5);
        $bookId2->setTitre('Aperiendum est igitur');
        $bookId2->addGenre($genreid5);
        $em->persist($genreid5);
        $em->flush();

        // Requêtes de suppression :

        $livre123 = $livreRepository->find(123);

        if ($livre123) {
            $em->remove($livre123);
            $em->flush();
        }

        return $this->render('test/livre.html.twig', [
            'test' => 'message livre test',
            'livresAll' => $livresAll,
            'livre1' => $livre1,
            'findTitle' => $findTitle,
            'user2Books' => $user2Books,
            'findGenre' => $findGenre,
        ]);
    }

    #[Route('/emprunteur', name: 'emprunteur')]
    public function emprunteur(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $emprunteurRepository = $em->getRepository(Emprunteur::class);
        $userRepository = $em->getRepository(User::class);

        // - la liste complète des emprunteurs, triée par ordre alphabétique de nom et prénom
        $findAllEmprunteurs = $emprunteurRepository->findAllEmprunteur();

        // - l'unique emprunteur dont l'id est `3`

        $emprunteur3 = $emprunteurRepository->find(3);

        // - l'unique emprunteur qui est relié au user dont l'id est `3`

        $user3 = $userRepository->find(3);

        // - la liste des emprunteurs dont le nom ou le prénom contient le mot clé `foo`, triée par ordre alphabétique de nom et prénom

        $findFooWord = $emprunteurRepository->findWordFoo('foo');

        // - la liste des emprunteurs dont le téléphone contient le mot clé `1234`, triée par ordre alphabétique de nom et prénom

        $findNumber = $emprunteurRepository->findTel('1234');

        return $this->render('test/emprunteur.html.twig', [
            'title' => 'je suis un titre de test',
            'findAllEmprunteurs' => $findAllEmprunteurs,
            'emprunteur3' => $emprunteur3,
            'user3' => $user3,
            'findFoo' => $findFooWord,
            'findTel' => $findNumber,
        ]);
    }

    #[Route('/emprunt', name: 'emprunt')]
    public function emprunt(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $empruntRepository = $em->getRepository(Emprunt::class);
        $livreRepository = $em->getRepository(Livre::class);
        $emprunteurRepository = $em->getRepository(Emprunteur::class);

        // - la liste des 10 derniers emprunts au niveau chronologique, triée par ordre **décroissant** de date d'emprunt (le plus récent en premier)

        $value = 10;
        $findLastEmprunt = $empruntRepository->findTenLastEmprunt($value);

        // - la liste des emprunts de l'emprunteur dont l'id est `2`, triée par ordre **croissant** de date d'emprunt (le plus ancien en premier)

        $emprunt2U = $empruntRepository->find(2);

        $emprunt2 = $empruntRepository->findEmprunt2($emprunt2U);


        // - la liste des emprunts du livre dont l'id est `3`, triée par ordre **décroissant** de date d'emprunt (le plus récent en premier)

        $emprunt3U = $empruntRepository->find(3);
        $emprunt3 = $empruntRepository->findEmprunt3($emprunt3U);

        // - la liste des emprunts qui n'ont pas encore été retournés (c-à-d dont la date de retour est nulle), triée par ordre **croissant** de date d'emprunt (le plus ancien en premier)

        $empruntList = $empruntRepository->findEmpruntNull();


        // - l'unique emprunt relié au livre dont l'id est `3`

       
        $livre3 = $empruntRepository->EmpruntLivre3(3);

        // requete de création

        $newEmprunteur = $emprunteurRepository->find(1);
        $newBook = $livreRepository->find(1);


        $newEmprunt = new Emprunt();
        $newEmprunt->setDateEmprunt(new DateTime('01/12/2020 16:00:00'));
        $newEmprunt->setDateRetour(null);
        $newEmprunt->setEmprunteur($newEmprunteur);
        $newEmprunt->setLivre($newBook);

        $em->persist($newEmprunt);
        $em->flush();


        // requete de mise à jour 

        $majEmprunt = $empruntRepository->find(3);
        $majEmprunt->setDateRetour(new DateTime('01/05/2020 10:00:00'));

        $em->persist($majEmprunt);
        $em->flush();   


        // requete de suppression

        $id42 = $empruntRepository->find(42);

        if($id42) {
            $em->remove($id42);
            $em->flush();
        }


        return $this->render('test/emprunt.html.twig', [
            'title' => 'test emprunt',
            'lastEmprunt' => $findLastEmprunt,
            'emprunt2' => $emprunt2,
            'emprunt3' => $emprunt3,
            'empruntList' => $empruntList,
            'livre3' => $livre3,
        ]);
    }
}
