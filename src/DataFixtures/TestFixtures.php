<?php

namespace App\DataFixtures;


use DateTime;
use App\Entity\User;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\Auteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Date;

class TestFixtures extends Fixture implements FixtureGroupInterface
{
    private $faker;
    private $hasher;
    private $manager;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = FakerFactory::create('fr_FR');
        $this->hasher = $hasher;
    }

    public static function getGroups(): array
    {
        return ['test'];
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->loadAuteurs();
        $this->loadGenres();
        $this->loadLivres();
    }

    public function loadAuteurs(): void
    {
        $datas = [
            [
                'nom' => 'alice',
                'prenom' => 'azar',

            ],
            [
                'nom' => 'bob',
                'prenom' => 'berger',

            ],
            [
                'nom' => 'claire',
                'prenom' => 'canin',

            ],
            [
                'nom' => 'martin',
                'prenom' => 'meurchier',

            ],
        ];

        foreach ($datas as $data) {
            $auteur = new Auteur();
            $auteur->setNom($data['nom']);
            $auteur->setPrenom($data['prenom']);

            $this->manager->persist($auteur);
        }
        $this->manager->flush();
    }

    public function loadGenres(): void
    {
        $datas = [
            [
                'nom' => 'poésie',
                'description' => null
            ],
            [
                'nom' => 'nouvelle',
                'description' => null
            ],
            [
                'nom' => 'roman historique',
                'description' => null
            ],
            [
                'nom' => 'roman d\'amour',
                'description' => null
            ],
            [
                'nom' => 'roman d\'aventure',
                'description' => null
            ],
            [
                'nom' => 'science-fiction',
                'description' => null
            ],
            [
                'nom' => 'fantasy',
                'description' => null
            ],
            [
                'nom' => 'biographie',
                'description' => null
            ],
            [
                'nom' => 'conte',
                'description' => null
            ],
            [
                'nom' => 'témoignage',
                'description' => null
            ],
            [
                'nom' => 'théatre',
                'description' => null
            ],
            [
                'nom' => 'essai',
                'description' => null
            ],
            [
                'nom' => 'journal intime',
                'description' => null
            ]

        ];

        foreach ($datas as $data) {
            $genre = new Genre();
            $genre->setNom($data['nom']);
            $genre->setDescription($data['description']);

            $this->manager->persist($genre);
        }
        $this->manager->flush();
    }


    public function loadLivres(): void
    {
        $repositoryAuteur = $this->manager->getRepository(Auteur::class);
        $auteurs = $repositoryAuteur->findall();
        $auteur1 = $repositoryAuteur->find(1);
        $auteur2 = $repositoryAuteur->find(2);
        $auteur3 = $repositoryAuteur->find(3);
        $auteur4 = $repositoryAuteur->find(4);

        $repositoryGenre = $this->manager->getRepository(Genre::class);
        $genres = $repositoryGenre->findAll();
        $genre1 = $repositoryGenre->find(1);
        $genre2 = $repositoryGenre->find(2);
        $genre3 = $repositoryGenre->find(3);
        $genre4 = $repositoryGenre->find(4);


        $datas = [
            [
                'titre' => 'lorem',
                'anneeEdition' => 2010,
                'nombrePages' => 1200,
                'codeIsbn' => '9786741176761',
                'auteurs' => $auteur1,
                'genres' => [$genre1],

            ],
            [
                'titre' => 'Ipsum',
                'anneeEdition' => 2013,
                'nombrePages' => 120,
                'codeIsbn' => '9786741176888',
                'auteurs' => $auteur2,
                'genres' => [$genre2],

            ],
            [
                'titre' => 'Jutsu',
                'anneeEdition' => 2013,
                'nombrePages' => 120,
                'codeIsbn' => '9786741176888',
                'auteurs' => $auteur3,
                'genres' => [$genre3],

            ],
            [
                'titre' => 'dolor',
                'anneeEdition' => 2013,
                'nombrePages' => 850,
                'codeIsbn' => '9786741176542',
                'auteurs' => $auteur3,
                'genres' => [$genre3],

            ],
            [
                'titre' => 'Sante',
                'anneeEdition' => 2000,
                'nombrePages' => 250,
                'codeIsbn' => '9786741176146',
                'auteurs' => $auteur4,
                'genres' => [$genre4],

            ],

        ];
        foreach ($datas as $data) {
            $livre = new Livre();
            $livre->setTitre($data['titre']);
            $livre->setAnneeEdition($data['anneeEdition']);
            $livre->setNombrePages($data['nombrePages']);
            $livre->setCodeIsbn($data['codeIsbn']);
            $livre->setAuteur($data['auteurs']);

            $livre->addGenre($data['genres'][0]);

            $dd = $livre;

            $this->manager->persist($livre);
        }
        $this->manager->flush();
    }
}
