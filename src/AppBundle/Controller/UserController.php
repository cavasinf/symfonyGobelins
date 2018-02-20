<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * @Route("/user", name="user_")
 */
class UserController extends Controller
{
    /**
     * @Route("/create",name="create")
     * @param Request $request
     * @param EncoderFactoryInterface $encoderFactory
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, EncoderFactoryInterface $encoderFactory)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN',null,'NOPE');

        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $encoder = $encoderFactory->getEncoder($user);
            $hashPassword = $encoder->encodePassword($user->getPassword(), null);

            $user->setPassword($hashPassword);

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'User created'
            );

            return $this->redirectToRoute("user_list");
        }
        return $this->render("user/create.html.twig", [
            'userForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/list",name="list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/update/{user}")
     * @param Request $request
     * @param user $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, User $user)
    {
        return $this->render('user/update.html.twig', array(// ...
        ));
    }

    /**
     * @Route("/delete/{user}")
     * @param Request $request
     * @param user $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, User $user)
    {
        return $this->render('user/delete.html.twig', array(// ...
        ));
    }

}
