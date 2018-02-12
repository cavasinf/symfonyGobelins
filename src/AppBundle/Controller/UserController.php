<?php

namespace AppBundle\Controller;

use AppBundle\Entity\user;
use AppBundle\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user")
 */

class UserController extends Controller
{
    /**
     * @Route("/create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {

        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'user created'
            );

            return $this->redirectToRoute("user_list");
        }
        return $this->render("user/create.html.twig", [
            'showForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{user}")
     * @param Request $request
     * @param user $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request,User $user)
    {
        return $this->render('user/update.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/delete/{user}")
     * @param Request $request
     * @param user $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request,User $user)
    {
        return $this->render('user/delete.html.twig', array(
            // ...
        ));
    }

}
