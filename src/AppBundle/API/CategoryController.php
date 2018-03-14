<?php

namespace AppBundle\API;

use AppBundle\Entity\Category;
use AppBundle\Entity\Show;
use AppBundle\Repository\CategoryRepository;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Swagger\Annotations as SWG;

/**
 * @Route("/category",name="api_category_")
 */
Class CategoryController extends Controller
{

    /**
     * @Method({"GET"})
     * @Route("/getAll", name="list")
     * @param SerializerInterface $serializer
     * @return Response
     *
     * @SWG\Tag(name="category")
     * @SWG\Response(
     *     response=200,
     *     description="Returns a json of all shows",
     * )
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
     *
     * @SWG\Tag(name="category")
     * @SWG\Response(
     *     response=200,
     *     description="Returns a json of the category",
     * )
     */

    public function findByIdAction(SerializerInterface $serializer,Category $category)
    {
        $data = $serializer->serialize($category, 'json');
        return new Response($data, Response::HTTP_OK,['Content-Type' => 'application/json']);

    }


    /**
     * @Method({"GET"})
     * @Route("/findById/{id}/shows", name="findShowByCategoryId")
     * @param SerializerInterface $serializer
     * @param Category $category
     * @return Response
     *
     * @SWG\Tag(name="category")
     * @SWG\Response(
     *     response=200,
     *     description="Returns JSON of the category shows",
     * )
     */
    public function showsByCategoryAction(SerializerInterface $serializer, Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $shows = $em->getRepository(Show::class)->findBy(["category" => $category]);
        $data = $serializer->serialize($shows, 'json');
        return new Response($data, Response::HTTP_OK,['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/deleteById/{id}", name="deleteCategoryById", methods={"DELETE"})
     * @param SerializerInterface $serializer
     * @param Request $request
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * @SWG\Tag(name="category")
     * @SWG\Response(
     *     response=204,
     *     description="Delete category",
     * )
     */
    public function deleteAction(SerializerInterface $serializer,Request $request, Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        $message = ["Category has been deleted"];
        $data = $serializer->serialize($message, 'json');
        return new Response($data, Response::HTTP_OK,['Content-Type' => 'application/json']);
    }

    /**
     * @Method({"POST"})
     * @Route("", name="createCategory")
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * @SWG\Tag(name="category")
     * @SWG\Response(
     *     response=201,
     *     description="Create category",
     * )
     * @SWG\Parameter(
     *     name="request",
     *     type="json",
     *     in="body",
     *     description="json object",
     *     @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="name",type="string", example="Action"),
     *         )
     * )
     */
    public function createAction(Request $request, ValidatorInterface $validator)
    {
        $content = json_decode($request->getContent());

        $category = new Category();
        $category->setName($content->name);
        $constraintValidation = $validator->validate($category);

        if ($constraintValidation->count() == 0) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->json("Category created", Response::HTTP_CREATED);
        }

        $response = ValidatorResponseTreatment::validatorToJson($constraintValidation->get(0));

        return $this->json($response, Response::HTTP_BAD_REQUEST);
    }
}