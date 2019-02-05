<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Review;
use App\Entity\User;
use App\Repository\ProductRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

//         gestion des users
        $users = [];
        for ($i = 0; $i <= 10; $i ++){
            $user = new User();

            $user->setEmail($faker->email)
                ->setPassword($this->encoder->encodePassword($user, 'password'));

            $manager->persist($user);
            $users[] = $user;
        }
        // créer 12 articles
        for ($j = 0; $j <= 12; $j ++){
            $product = new Product();

            $user = $users[mt_rand(0, count($users) - 1)];

            $product->setTitle($faker->sentence(8))
                    ->setUser($user)
                    ->setDescription($faker->paragraph(5));

            $manager->persist($product);
            // création de commentaire par produit
            for ($k = 1; $k <=mt_rand(4,10); $k ++){
                $review = new Review();
                $user = $users[mt_rand(0, count($users) - 1)];
                $review->setAuthor($user)
                        ->setDescription($faker->paragraph(5))
                        ->setProduct($product)
                        ->setRating(mt_rand(4,10));
                $manager->persist($review);
            }
        }
        $manager->flush();
    }
}
