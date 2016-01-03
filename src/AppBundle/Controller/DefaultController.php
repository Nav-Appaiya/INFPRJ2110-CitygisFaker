<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Users;
use Faker\Factory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * Loads home page
     * this twig file is found at /www/app/Resource/ 
     * not in the actual src/AppBundle file structure
     */
    public function indexAction(Request $request)
    {
        dump($this->fake());
        for ($x = 0; $x <= 10; $x++) {
            $this->createUsers();
        }


        return $this->render('AppBundle::layout.html.twig');
    }

    public function createUsers()
    {
        $em = $this->getDoctrine()->getManager();
        $users = new Users();
        header("Content-Type: application/json");
        $em->persist($users);
        $em->flush();
    }

    public function fake($fakeThis = 'name')
    {
        $faker = Factory::create();
        return $faker->$fakeThis;
    }
}
