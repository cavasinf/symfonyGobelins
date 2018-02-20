<?php

namespace AppBundle\API;



use AppBundle\API\Controller;
use AppBundle\Entity\User;
use AppBundle\Repository\userRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/users",name="api_category_")
 */
Class UserController extends Controller
{

    /**
     * @Method({"GET"})
     * @Route("/getAll", name="list")
     * @param SerializerInterface $serializer
     * @return Response
     */

    public function listAction(SerializerInterface $serializer)
    {

        /** @var userRepository $showsRepo */
        $usersRepo = $this->getDoctrine()->getRepository('AppBundle:User');
        $users = $usersRepo->findAll();

        $data = $serializer->serialize($users, 'json');
        return new Response($data, Response::HTTP_OK,['Content-Type' => 'application/json']);
    }


    /**
     * @Method({"GET"})
     * @Route("/findById/{id}", name="findById")
     * @param SerializerInterface $serializer
     * @param User $user
     * @return Response
     */

    public function findByIdAction(SerializerInterface $serializer, User $user)
    {
        $data = $serializer->serialize($user, 'json');
        return new Response($data, Response::HTTP_OK,['Content-Type' => 'application/json']);
    }

    /**
     * @Method({"POST"})
     * @Route("", name="create")
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @return Response
     */

    public function createAction(Request $request,SerializerInterface $serializer, ValidatorInterface $validator)
    {
        /** @var User $user */
        $user = $serializer->deserialize($request->getContent(),User::class,'json');

        dump($user);die;

        $constraintValidatorList = $validator->validate($user);

        if ($constraintValidatorList->count() == 0) {
            $em = $this->getDoctrine()->getManager();

            $user->setPassword();

            $em->persist($user);
            $em->flush();

            return $this->returnResponse('User created',Response::HTTP_CREATED);
        }
    }
}