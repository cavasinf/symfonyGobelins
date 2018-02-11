<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use AppBundle\AppBundle;
use AppBundle\Type\ShowType;
use AppBundle\Entity\Show;
use AppBundle\Entity\Category;
use AppBundle\File\FileUploader;



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
     */

    public function listAction()
    {
        $shows = $this->getDoctrine()->getRepository(Show::class)->findAll();
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
        return $this->render('_includes/category.html.twig',[
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function createAction(Request $request, FileUploader $fileUploader)
    {
        $show = new Show();

        $form  = $this->createForm(ShowType::class, $show);

        $form->handleRequest($request);

        if($form->isValid()) {

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
     * @Route("/update/{id}", name="update", requirements={"id"="\d+"})
     * @Method({"GET", "PUT"})
     * @param Request $request
     * @param Show $show
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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
}
