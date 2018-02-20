<?php

namespace AppBundle\API;

use AppBundle\Entity\Category;
use AppBundle\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/categories",name="api_category_")
 */
Class CategoryController extends Controller
{

    /**
     * @Method({"GET"})
     * @Route("/getAllgetAll", name="list")
     * @param SerializerInterface $serializer
     * @return Response
     */

    public function listAction(SerializerInterface $serializer)
    {

        /** @var CategoryRepository $showsRepo */
        $categoriesRepo = $this->getDoctrine()->getRepository('AppBundle:Category');
        $categories = $categoriesRepo->findAll();

        $data = $serializer->serialize($categories, 'json');
        return new Response($data, Response::HTTP_OK,['Content-Type' => 'application/json']);
    }


    /**
     * @Method({"GET"})
     * @Route("/findById/{id}", name="findById")
     * @param SerializerInterface $serializer
     * @param Category $category
     * @return Response
     */

    public function findByIdAction(SerializerInterface $serializer, Category $category)
    {
        $data = $serializer->serialize($category, 'json');
        return new Response($data, Response::HTTP_OK,['Content-Type' => 'application/json']);
    }
}