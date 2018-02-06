<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use AppBundle\Type\ShowType;

use AppBundle\AppBundle;

class ShowController extends Controller
{
    /**
     * @Route("/show")
     */

    public function listAction()
    {
        return $this->render('show/list.html.twig',[]);
    }

    public function categoriesAction()
    {
        return $this->render('_includes/category.html.twig',[
            "categories" => ["Web Design","HTML","Freebies","CSS","...","...","...","...","..."]
        ]);
    }

    /**
     * @Route("/create")
     */

    public function createAction()
    {
        $form  = $this->createForm(ShowType::class);
        return $this->render("show/create.html.twig", [
            'showForm' => $form->createView()
        ]);
    }
}
