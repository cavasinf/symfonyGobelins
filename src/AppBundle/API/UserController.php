<?php

namespace AppBundle\API;


use AppBundle\API\Controller;
use AppBundle\Entity\Show;
use AppBundle\Entity\User;
use AppBundle\Repository\userRepository;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Swagger\Annotations as SWG;

/**
 * @Route("/user",name="api_user_")
 */
Class UserController extends Controller
{

    /**
     * @Method({"GET"})
     * @Route("/getAll", name="list")
     * @param SerializerInterface $serializer
     * @return Response
     *
     * @SWG\Tag(name="user")
     * @SWG\Response(
     *     response=200,
     *     description="Return JSON of all users",
     * )
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
     *
     * @SWG\Tag(name="user")
     * @SWG\Response(
     *     response=200,
     *     description="Return JSON of one user",
     * )
     */

    public function findByIdAction(SerializerInterface $serializer,User $user)
    {
        $data = $serializer->serialize($user, 'json');
        return new Response($data, Response::HTTP_OK,['Content-Type' => 'application/json']);
    }

    /**
     * @Method({"GET"})
     * @Route("/createPassword/{password}", name="createPassword")
     * @param EncoderFactoryInterface $encoderFactory
     * @param $password
     * @return Response
     *
     * @SWG\Tag(name="user")
     * @SWG\Response(
     *     response=200,
     *     description="Return JSON hashed password",
     * )
     */

    public function createPassword(EncoderFactoryInterface $encoderFactory,$password)
    {
        $user = new User();
        $user->setPassword($password);
        $em = $this->getDoctrine()->getManager();

        $encoder = $encoderFactory->getEncoder($user);
        $hashPassword = $encoder->encodePassword($user->getPassword(), null);

        return $this->json($hashPassword, Response::HTTP_OK);

    }

    /**
     * @Method({"GET"})
     * @Route("/findById/{id}/shows", name="findShowByUserId")
     * @param SerializerInterface $serializer
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * @SWG\Tag(name="user")
     * @SWG\Response(
     *     response=200,
     *     description="Return JSON of all shows created by the user",
     * )
     */
    public function showsByUserAction(SerializerInterface $serializer, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $shows = $em->getRepository(Show::class)->findBy(["author" => $user]);
        $data = $serializer->serialize($shows, 'json');
        return new Response($data, Response::HTTP_OK,['Content-Type' => 'application/json']);
    }

    /**
     * @Method({"POST"})
     * @Route("", name="create")
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param EncoderFactoryInterface $encoderFactory
     * @return Response
     *
     * @SWG\Tag(name="user")
     * @SWG\Response(
     *     response=201,
     *     description="Create user",
     * )
     * @SWG\Parameter(
     *     name="request",
     *     type="json",
     *     in="body",
     *     description="json object",
     *     @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="username",type="string", example="cavasinf"),
     *             @SWG\Property(property="email",type="string", example="test@test.test"),
     *             @SWG\Property(property="firstname",type="string", example="florian"),
     *             @SWG\Property(property="lastname",type="string", example="cavasin"),
     *             @SWG\Property(property="password",type="string", example="1234"),
     *             @SWG\Property(property="roles",type="array",
     *              @SWG\Items(
     *                      type="string",
     *                      example="ROLE_USER"
     *                  ),
     *              ),
     *         )
     * )
     */

    public function createAction(Request $request, ValidatorInterface $validator, EncoderFactoryInterface $encoderFactory)
    {
        $content = json_decode($request->getContent());

        $user = new User();
        $user->setUsername($content->username);
        $user->setEmail($content->email);
        $user->setFirstname($content->firstname);
        $user->setLastname($content->lastname);
        $user->setPassword($content->password);
        $user->setRoles($content->roles);
        $constraintValidationList = $validator->validate($user);

        if ($constraintValidationList->count() == 0) {
            $encoder = $encoderFactory->getEncoder($user);
            $password = $encoder->encodePassword($content->password, null);
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->json("User created", Response::HTTP_CREATED);
        }

        $response = ValidatorResponseTreatment::validatorToJson($constraintValidationList->get(0));
        return $this->json($response, Response::HTTP_BAD_REQUEST);
    }
}