<?php

namespace AppBundle\Controller;

use AppBundle\ShowFinder\ShowFinder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use AppBundle\AppBundle;
use AppBundle\Type\ShowType;
use AppBundle\Entity\Show;
use AppBundle\Entity\Category;
use AppBundle\File\FileUploader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManager;


/**
 * @Route(
 *     "/show",
 *     name="show"
 *      )
 */
class ShowController extends Controller
{
    /**
     * @Route(
     *     "/list",
     *     name="_list"
     *   )
     * @param Request $request
     * @param ShowFinder $showFinder
     * @return Response
     */

    public function listAction(Request $request,ShowFinder $showFinder)
    {
        $session = $request->getSession();
        $showRepository = $this->getDoctrine()->getRepository(Show::class);

        if($session->has('query_search_shows'))
        {
            $shows = $showFinder->findByName($session->get('query_search_shows'));
            $request->getSession()->remove('query_search_shows');
        } else {
            $shows = $showRepository->findAll();
        }
        /*
        if ($session->has('query_search_shows')) {
            $querySearchShows = $session->get('query_search_shows');
            $shows = $showRepository->findAllByQuery($querySearchShows);
            $request->getSession()->remove('query_search_shows');
        } else {
            $shows = $showRepository->findAll();
        }*/


        return $this->render('show/list.html.twig', [
            'shows' => $shows
        ]);
    }

//    How to route {id] & crate in the same time ???

    /**
     * @Route(
     *     "/show/{id}",
     *     name="_show"
     *   )
     */

    public function showAction($id)
    {
        $show = $this->getDoctrine()->getRepository(Show::class)->find($id);
        return $this->render('show/show.html.twig', [
            'show' => $show
        ]);
    }

    public function categoriesAction()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('_includes/category.html.twig', [
            "categories" => $categories
        ]);
    }

    /**
     * @Route(
     *     "/create",
     *     name="_create"
     *   )
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */

    public function createAction(Request $request, FileUploader $fileUploader)
    {
        $show = new Show();

        $form = $this->createForm(ShowType::class, $show);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $generatedFileName = $fileUploader->upload(
                $show->getTmpPictureFile(),
                $show->getCategory()->getName()
            );
            $show->setMainPicture($generatedFileName);

            $em = $this->getDoctrine()->getManager();

            $em->persist($show);
            $em->flush();

            $this->addFlash(
                'success',
                'Show created'
            );

            return $this->redirectToRoute("show_list");
        }
        return $this->render("show/create.html.twig", [
            'showForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/update/{id}", name="_update", requirements={"id"="\d+"})
     * @Method({"GET", "PUT"})
     * @param Request $request
     * @param Show $show
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function updateAction(Request $request, Show $show, FileUploader $fileUploader)
    {
        $showForm = $this->createForm(
            ShowType::class,
            $show,
            ['validation_groups' => 'update',
                'method' => 'PUT']
        );

        $showForm->handleRequest($request);

        if ($showForm->isValid()) {
            $generatedFileName = $fileUploader->upload(
                $show->getTmpPictureFile(),
                $show->getCategory()->getName()
            );

            $show->setMainPicture($generatedFileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($show);
            $em->flush();

            $this->addFlash('success', 'Show successfully updated');

            return $this->redirectToRoute('show_list');
        }

        return $this->render(
            'show/create.html.twig',
            ['showForm' => $showForm->createView()]
        );
    }

    /**
     * @Route("/delete/{id}",name="_delete")
     * @param Request $request
     * @param $showId
     * @param CsrfTokenManager $crsfTokenManager
     * @return RedirectResponse
     */
    public function deleteAction(Request $request ,$showId, CsrfTokenManager $crsfTokenManager)
    {

        $doctrine = $this->getDoctrine();
        $show = $doctrine->getRepository('AppBundle:Show')->find($showId);

        if (!$show) {
            throw new NotFoundHttpException(sprintf('There is no show with the id %d', $show->getId()));
        }

        $crsfToken = new CsrfToken('delete_show', $request->request->get('_csrf_token'));

        if ($crsfTokenManager->isTokenValid($crsfToken)) {

            $doctrine->getManager()->remove($show);
            $doctrine->getManager()->flush();

            $this->addFlash('success', 'The show has been successfully removed !');
        }
        else
        {
            $this->addFlash('danger', 'The crsf token is not valid. Not able to delete this show.');
        }

        return $this->redirectToRoute("show_list");

    }


    /**
     * @Route("/search", name="_search")
     * @Method({"POST"})
     * @param Request $request
     * @return RedirectResponse
     */
    public function searchAction(Request $request)
    {
        $request->getSession()->set('query_search_shows', $request->request->get('query'));
        return $this->redirectToRoute('show_list');
    }
}
