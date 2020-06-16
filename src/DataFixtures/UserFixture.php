<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
    private $passwordEncoder;
    public function __construct( UserPasswordEncoderInterface $passwordEncoder )
    {
        $this->passwordEncoder=$passwordEncoder;
    }
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_user',function($i) use($manager){

            $user=new User;
            $user->setEmail(sprintf('spacebar%d@example.com',$i));
            $user->setFirstName($this->faker->firstName);
            $user->agreeTerms();
            if($this->faker->boolean){
                $user->setTwitterUsername($this->faker->userName);
            }
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));

            //With createMany() method, you do not need to call persist() or flush() 
            //on the object that you return
            
            //if you create some objects manually - like this - you do need to call persist()
            $apiToken1= new ApiToken($user);
            $apiToken2= new ApiToken($user);
            $manager->persist($apiToken1);
            $manager->persist($apiToken2);

            return $user;
        });

        $this->createMany(3, 'admin_user',function($i){

            $user=new User;
            $user->setEmail(sprintf('admin%d@thespacebar.com',$i));
            $user->setFirstName($this->faker->firstName);
            $user->agreeTerms();
            $user->setRoles(['ROLE_ADMIN']);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));
            return $user;
        });

        $manager->flush();
    }
}
