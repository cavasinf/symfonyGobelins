<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 05/02/2018
 * Time: 16:22
 */

namespace AppBundle\Controller;


use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpKernel\Tests\Controller;

class ShowType extends Controller
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder
            ->add("name")
            ->add("category")
            ->add("abstract")
            ->add("country",CountryType::class)
            ->add("author")
            ->add("releaseDate")
            ->add("mainPicture",FileType::class)
        ;
    }
}