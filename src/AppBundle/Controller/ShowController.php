<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use AppBundle\Type\ShowType;
use AppBundle\Entity\Show;

use AppBundle\AppBundle;
use Symfony\Component\HttpFoundation\Request;

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
     *     "/",
     *     name="_list"
     *   )
     */

    public function listAction()
    {
        return $this->render('show/list.html.twig',[]);
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function createAction(Request $request)
    {
        $show = new Show();

        $form  = $this->createForm(ShowType::class, $show);

        $form->handleRequest($request);

        if($form->isValid()) {

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
}
