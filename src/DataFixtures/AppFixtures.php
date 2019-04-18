<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\ArticleLike;
use App\Entity\ArticleTag;
use App\Entity\Comment;
use App\Entity\User;
use App\Helper\Constante;
use App\Repository\ArticleRepository;
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

        $admin = new User();
        $admin->setPrenom("admin");
        $admin->setNom("admin");
        $admin->setEmail("admin@admin.com");
        $admin->setIsActivate(true);
        $admin->setAvatar("http://".Constante::IP_ADDRESS."/api/assets/image/icons1.png");
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setPassword($this->encoder->encodePassword($admin, 'password'));
        $manager->persist($admin);
//         gestion des users
        $users = [];
        for ($i = 0; $i <= 5; $i ++){
            $user = new User();
            $nb = mt_rand(0,23);
            $user->setEmail($faker->email);
            $user->setPrenom($faker->name);
            $user->setIsActivate(true);
            $user->setAvatar("http://".Constante::IP_ADDRESS."/api/assets/image/icons".$nb.".png");
            $user->setNom($faker->lastName);
            $user->setPassword($this->encoder->encodePassword($user, 'password'));

            $manager->persist($user);
            $users[] = $user;
        }

        //3/4 catégories
        for ($i = 0; $i <= 3; $i ++) {
            $tag = new ArticleTag();
            $tag->setName($faker->sentence);
            $tag->setDescription($faker->word(2));

            $manager->persist($tag);

            // créer 12 articles
            for ($j = 0; $j <= 12; $j++) {
                $article = new Article();

                $user = $users[mt_rand(0, count($users) - 1)];

                $title = $faker->sentence();
                $article->setTitle($title)
                    ->setPrice(mt_rand(13, 140))
                    ->setUser($user)
                    ->setTag($tag)
                    ->setContent($faker->paragraph(3))
                    ->setCreatedAt(new \DateTime())
                    ->setDescription($faker->paragraph(3));

                $manager->persist($article);
                for ($l = 0; $l < mt_rand(0,10); $l ++){
                    $like = new ArticleLike();
                    $like->setArticle($article)
                            ->setUser($faker->randomElement($users));
                    $manager->persist($like);
                }

                // création de commentaire par produit
                for ($k = 1; $k <= mt_rand(4, 10); $k++) {
                    $review = new Comment();
                    $user = $users[mt_rand(0, count($users) - 1)];
                    $review->setAuthor($user)
                        ->setDescription($faker->paragraph(5))
                        ->setArticle($article)
                        ->setCreatedAt(new \DateTime())
                        ->setRating(mt_rand(0, 5));
                    $manager->persist($review);
                }
            }
        }
        $manager->flush();
    }
}
