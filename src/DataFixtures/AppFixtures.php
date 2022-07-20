<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Articles;
use App\Entity\Blogpost;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
{
    $this->passwordHasher = $passwordHasher;
}
    public function load(ObjectManager $manager): void
    {
      
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user->setNom($faker->lastName());
        $user->setPrenom($faker->firstName());
        $user->setEmail($faker->email());
        $user->setDescription($faker->text());
        $user->setImage('https://via.placeholder.com/360');
        $user->setbirthday($faker->DateTime($format = 'D-m-y'));
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
        //creation de 10 blogpost
        for ($i = 0; $i < 10; $i++) {
            $blogpost = new Blogpost();
            /** @phpstan-ignore-next-line */
            $blogpost->setTitre($faker->words(3, true))
                ->setCratedAt($faker->dateTimeBetween( '-6 months','now'))
                ->setContenu($faker->text(350))
                ->setSlug($faker->slug(3))
                ->setUser($user);
                $manager->persist($blogpost);
                //creation de 10 articles
        }
                for ($j = 0; $j <= 10; $j++) {
                    $articles = new Articles();
                    $articles->setImage($faker->imageUrl())
                    ->setdescription($faker->text(350))
                    ->setPrice($faker->randomFloat(2, 100, 9999));
                    $manager->persist($articles);
                }
        
                $manager->flush();
            }
        }
        

       
    

