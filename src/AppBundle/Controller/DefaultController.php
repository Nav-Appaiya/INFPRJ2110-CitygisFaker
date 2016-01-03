<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Users;
use Faker\Factory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Client;
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
        header('Content-Type: text/plain');

        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://149.210.236.249',
            'defaults' => [
                'headers' => [
                    'Authorization' => 'Token 90f44a24a6bd93a8ca9c21d0b9e0d81d5ab20da2'
                ]
            ]
        ]);
        $request = $client->createRequest("GET",'http://149.210.236.249/positions' );
        $request->setPort(8000);

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
