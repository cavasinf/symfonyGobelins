<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route(name="login_")
 */

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function LoginAction(AuthenticationUtils $authUtils)
    {
//        dump($authUtils->getLastAuthenticationError());die;
            return $this->render("login/login.html.twig",[
                'error' => $authUtils->getLastAuthenticationError(),
                'lastUsername' => $authUtils->getLastUsername()
            ]);
    }

    /**
     * @Route("/login_check", name="check")
     */
    public function LoginCheckAction()
    {
        dump("Nothing here 👌🏿");
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        dump('This code is never executed 👌🏿');
    }

}
