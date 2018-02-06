<?php

namespace AppBundle\Entity;

/**
 * @ORM\Entity
 * @ORM\Table(name="show")
 */

class Show
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $category;

    /**
     * @ORM\Column(type="text")
     */
    private $abstract;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $author;

    /**
     * @ORM\Column(type="DateTime")
     */
    private $releaseDate;


    /**
     * @ORM\Column(type="blob")
     */
    private $mainPicture;

    /**
     * Show constructor.
     * @param $name
     * @param $category
     * @param $abstract
     * @param $country
     * @param $author
     * @param $releaseDate
     * @param $mainPicture
     */
    public function __construct($name, $category, $abstract, $country, $author, $releaseDate, $mainPicture)
    {
        $this->name = $name;
        $this->category = $category;
        $this->abstract = $abstract;
        $this->country = $country;
        $this->author = $author;
        $this->releaseDate = $releaseDate;
        $this->mainPicture = $mainPicture;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * @param mixed $abstract
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param mixed $releaseDate
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return mixed
     */
    public function getMainPicture()
    {
        return $this->mainPicture;
    }

    /**
     * @param mixed $mainPicture
     */
    public function setMainPicture($mainPicture)
    {
        $this->mainPicture = $mainPicture;
    }




}