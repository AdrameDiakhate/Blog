<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class Articles extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $category = new Category();
            $category->setName($faker->text);

            $user = new User();
            $user->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setUsername($faker->userName)
                ->setEmail($faker->email)
                ->setPassword($faker->password);
            $post = new Post();
            $post->setTitle($faker->title)
                ->setContent($faker->text)
                ->setImage($faker->imageUrl($width = 640, $height = 480))
                ->setUser($user)
                ->addCategory($category)
                ->setCreatedAt(new \DateTime());


            $user->addPost($post);

            $manager->persist($category);

            $manager->persist($user);

            $manager->persist($post);
        }

        $manager->flush();
    }
}
