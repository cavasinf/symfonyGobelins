<?php

namespace AppBundle\API;

use AppBundle\Entity\Category;
use AppBundle\Entity\Show;
use AppBundle\Entity\User;
use AppBundle\Repository\ShowRepository;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/show",name="api_show_")
 */
Class ShowController extends Controller
{

    /**
     * @Method({"GET"})
     * @Route("/getAll", name="list")
     * @param SerializerInterface $serializer
     * @return Response
     *
     * @SWG\Tag(name="show")
     * @SWG\Response(
     *     response=200,
     *     description="Returns a json of all shows",
     * )
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
     *
     * @SWG\Tag(name="show")
     * @SWG\Response(
     *     response=200,
     *     description="Returns a json of the show",
     * )
     */

    public function findByIdAction(SerializerInterface $serializer,Show $show)
    {
        $data = $serializer->serialize($show, 'json');
        return new Response($data, Response::HTTP_OK,['Content-Type' => 'application/json']);
    }


    /**
     * @Method({"DELETE"})
     * @Route("/deleteById/{id}", name="deleteById")
     * @param Request $request
     * @param Show $show
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * @SWG\Tag(name="show")
     * @SWG\Response(
     *     response=204,
     *     description="Delete show",
     * )
     */
    public function deleteAction(SerializerInterface $serializer,Request $request, Show $show)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($show);
        $em->flush();

        $message = ["Show has been deleted"];
        $data = $serializer->serialize($message, 'json');
        return new Response($data, Response::HTTP_OK,['Content-Type' => 'application/json']);
    }

    /**
     * @Method({"POST"})
     * @Route("", name="create")
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * @SWG\Response(
     *     response=201,
     *     description="Create show",
     * )
     * @SWG\Parameter(
     *     name="request",
     *     type="json",
     *     in="body",
     *     description="json object",
     *     @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="name",type="string", example="I Am Legend"),
     *             @SWG\Property(property="abstract",type="string", example="Years after a plague kills most of humanity......"),
     *             @SWG\Property(property="author",type="integer", example=1),
     *             @SWG\Property(property="country",type="string", example="USA"),
     *             @SWG\Property(property="releaseDate",type="string", example="2007-12-19"),
     *             @SWG\Property(property="mainPicture",type="string", example="https://images-na.ssl-images-amazon.com/images/M/MV5BYTE1ZTBlYzgtNmMyNS00ZTQ2LWE4NjEtZjUxNDJkNTg2MzlhXkEyXkFqcGdeQXVyNjU0OTQ0OTY@._V1_SY1000_SX675_AL_.jpg"),
     *             @SWG\Property(property="category",type="integer", example=1),
     *         )
     * )
     * @SWG\Tag(name="show")
     */
    public function createAction(Request $request, ValidatorInterface $validator)
    {
        $content = json_decode($request->getContent());

        $em = $this->getDoctrine()->getManager();

        $show = new Show();
        $show->setName($content->name);

        $author = $em->getRepository(User::class)->findOneBy(["id" => $content->author]);
        if (!$author) {
            throw new NotFoundHttpException('Author not found');
        }
        $show->setAuthor($author);

        $show->setDataSource(Show::CST_DATA_SOURCE_DB);
        $show->setMainPicture($content->picture);
        $show->setAbstract($content->abstract);

        $category = $em->getRepository(Category::class)->findOneBy(["id" => $content->categoryId]);
        if (!$category) {
            throw new NotFoundHttpException('Category not found');
        }
        /** @var Category $category */
        $show->setCategory($category);

        $show->setCountry($content->country);

        $releaseDate = new \DateTime($content->releaseDate);
        $releaseDate->format(DATE_ISO8601);
        $show->setReleaseDate($releaseDate);

        $constraintValidationList = $validator->validate($show, null, ["update"]);

        if ($constraintValidationList->count() == 0) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($show);
            $em->flush();

            return $this->json("Show was created", Response::HTTP_CREATED);
        }

        $response = ValidatorResponseTreatment::validatorToJson($constraintValidationList->get(0));
        return $this->json($response, Response::HTTP_BAD_REQUEST);
    }
}