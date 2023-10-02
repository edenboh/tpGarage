<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $hacher
    )
    {

    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $data=[
            ['email'=>"garage@mail.com","fullName"=>"garage admin","admin"=>true],
            ['email'=>"julien@mail.com","fullName"=>"julien perchberty","admin"=>false],
            ['email'=>"benoit@mail.com","fullName"=>"benoit foujols","admin"=>false]
        ];
        foreach ($data as $unUser){
            $user=new User();
            $user->setPrenom(explode(" ",$unUser['fullName'])[0]);
            $user->setNom(explode(" ",$unUser['fullName'])[1]);
            $user->setEmail($unUser['email']);
            $user->setPassword($this->hacher->hashPassword($user,'password'));
            $user->setRoles($unUser["admin"]?['ROLE_ADMIN']:['ROLE_USER']);//on pose la question si UnUser il est admin ou non si oui on met role admin sinon role user
            $manager->persist($user);
        }


        $manager->flush();
    }
}
