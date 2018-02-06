<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/index")
     */
    public function indexInfo(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }


    /**
     * @Route("/message/{username}",
     *     requirements = {"username" = ".*"},
     *      name="homepage")
     */
    public function index(Request $request,$username)
    {
        return new Response(
            $this->renderView('indexBundle/index.html.twig',[
                'username' => $username
            ]),
        Response::HTTP_NOT_FOUND);
    }
}
