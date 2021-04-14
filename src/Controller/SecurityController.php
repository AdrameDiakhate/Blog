<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
//use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /**
     * @Route("/signup", name="signup")
     */
    public function index(Request $request,EntityManagerInterface $manager): Response
    {
        $user=new User();
        
        $form= $this->createForm(LoginType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();
        }

        return $this->render('security/signup.html.twig', [
            'forms' => $form->createView()
        ]);

    }
}
