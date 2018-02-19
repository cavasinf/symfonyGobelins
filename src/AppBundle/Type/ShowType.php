<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 05/02/2018
 * Time: 16:22
 */

namespace AppBundle\Type;


use AppBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpKernel\Tests\Controller;

class ShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder
            ->add("name")
            ->add("category", EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add("abstract", TextareaType::class)
            ->add("country",CountryType::class)
            ->add("author")
            ->add("releaseDate")
            ->add('tmpPictureFile', FileType::class, ['label' => 'Main Picture']);
        ;
    }
}