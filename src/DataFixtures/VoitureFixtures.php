<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Voiture;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VoitureFixtures extends Fixture
{
    private $userRepo;
    public function __construct(UserRepository $userRepo){
        $this->userRepo=$userRepo;
    }


    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        $data=[
            ["BMW","1","2004"],
            ['peugeot','2',"2005"],
            ['citroen','3',"2023"]
        ];
        foreach ($data as $unCertaineVoiture)
        {
            $voiture=new Voiture();
            $voiture->setMarque($unCertaineVoiture[0]);
            $voiture->setModele($unCertaineVoiture[1]);
            $voiture->setAnnee($unCertaineVoiture[2]);
            //le manager on lui demande d'acceder au repo de la classe user
            $users=$manager->getRepository(User::class)->findAll();//pour recuperer tous les utilisateur dans un tableau
            $users=array_filter($users,function ($user) //sur chaque element du tablrau c un user et sur cette element j'excute la fonction dans {} cad je rajouote au tableau que ceux qui ont le role user
                ////je veux rajouter que au client une voiture et pas au role admin on filtre dans le tableau des user que ceux qui ont le role user
            {
                if (!in_array("ROLE_ADMIN",$user->getRoles()))
                {
                    return $user;
                }
            });
            $unUserAleatoire=array_rand($users);
            $voiture->setUser($users[$unUserAleatoire]);
            $manager->persist($voiture);

        }


        $manager->flush();
    }
}
