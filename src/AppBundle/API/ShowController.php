<?php

namespace AppBundle\API;

use AppBundle\Entity\Show;
use AppBundle\Repository\ShowRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * @Route("/shows",name="api_show_")
 * @SWG\Response(
 *     response=200,
 *     description="Returns the rewards of an user",
 *     @SWG\Schema(
 *         type="array",
 *         @Model(type=Reward::class, groups={"full"})
 *     )
 * )
 * @SWG\Parameter(
 *     name="order",
 *     in="query",
 *     type="string",
 *     description="The field used to order rewards"
 * )
 * @SWG\Tag(name="rewards")
 */
Class ShowController extends Controller
{

    /**
     * @Method({"GET"})
     * @Route("/getAll", name="list")
     * @param SerializerInterface $serializer
     * @return Response
     */

    public function listAction(SerializerInterface $serializer)
    {

        /** @var ShowRepository $showsRepo */
        $showRepo = $this->getDoctrine()->getRepository('AppBundle:Show');
        $shows = $showRepo->findAll();

        $data = $serializer->serialize($shows, 'json');
        return new Response($data, Response::HTTP_OK,['Content-Type' => 'application/json']);
    }

    /**
     * @Method({"GET"})
     * @Route("/findById/{id}", name="findById")
     * @param SerializerInterface $serializer
     * @param Show $show
     * @return Response
     */

    public function findByIdAction(SerializerInterface $serializer, Show $show)
    {
        $data = $serializer->serialize($show, 'json');
        return new Response($data, Response::HTTP_OK,['Content-Type' => 'application/json']);
    }
}