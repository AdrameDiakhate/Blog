<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    private $encoder;
  
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    /**
     * @Route("/signup", name="signup")
     */
    public function index(Request $request,EntityManagerInterface $manager): Response
    {
        $user=new User();
        
        $form= $this->createForm(LoginType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password=$this->encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($password);
            $manager->persist($user);
            $manager->flush();
            
            return $this->redirectToRoute('login'); 
        }

        return $this->render('security/signup.html.twig', [
            'forms' => $form->createView()
        ]);

    }
    
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('target_path');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        //return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
