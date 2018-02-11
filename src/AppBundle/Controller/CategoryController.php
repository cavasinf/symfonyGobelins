<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Type\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(
 *     "/category",
 *     name="category"
 * )
 */

class CategoryController extends Controller
{
    /**
     * @Route(
     *     "/create",
     *      name = "_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {

        $category = new Category();

        $form  = $this->createForm(CategoryType::class,$category);

        $form->handleRequest($request);

        if($form->isValid()) {

            $category = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash(
                'success',
                'Category created'
            );

            return $this->redirectToRoute("category_list");
        }

        return $this->render('category\create.html.twig', array(
            'categoryForm' => $form->createView()
        ));
    }

    /**
     * @Route(
     *     "/list",
     *     name="_list"
     * )
     */

    public function listAction(){

        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('category/list.html.twig', [
            'categories' => $categories
        ]);

    }

}
