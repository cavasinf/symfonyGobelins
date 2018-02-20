<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Date;
use JMS\Serializer\Annotation as JMS;

/**
 * Show
 *
 * @ORM\Table(name="s_show")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShowRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Show
{

    const CST_DATA_SOURCE_OMDB = "OMDB";
    const CST_DATA_SOURCE_DB = "In local Data Base";

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @JMS\Expose
     */
    private $name;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @JMS\Expose
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="abstract", type="string", length=255)
     * @JMS\Expose
     */
    private $abstract;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     * @JMS\Expose
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="shows")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @JMS\Expose
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="dataSource", type="string", length=255)
     * @JMS\Expose
     */
    private $dataSource;

    /**
     * @var Date
     *
     * @ORM\Column(name="releaseDate", type="date")
     * @JMS\Expose
     */
    private $releaseDate;

    /**
     * @var string
     * @ORM\Column
     * @Assert\Image(minWidth="750", minHeight="300", groups={"create"})
     * @JMS\Expose
     */

    private $mainPicture;
    /**
     * @var File
     */
    private $tmpPictureFile;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Show
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set category
     *
     * @param Category $category
     *
     * @return Show
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set abstract
     *
     * @param string $abstract
     *
     * @return Show
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;

        return $this;
    }

    /**
     * Get abstract
     *
     * @return string
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Show
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
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
     * @return string
     */
    public function getDataSource()
    {
        return $this->dataSource;
    }

    /**
     * @param string $dataSource
     */
    public function setDataSource($dataSource)
    {
        $this->dataSource = $dataSource;
    }


    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     *
     * @return Show
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return Date
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }


    /**
     * Get mainPicture
     *
     * @return string
     */
    public function getMainPicture()
    {
        return $this->mainPicture;
    }

    /**
     * @param $mainPicture
     * @return Show
     */
    public function setMainPicture($mainPicture)
    {
        $this->mainPicture = $mainPicture;
        return $this;
    }
    /**
     * @return File
     */
    public function getTmpPictureFile()
    {
        return $this->tmpPictureFile;
    }
    /**
     * @param File $tmpPictureFile
     * @return Show
     */
    public function setTmpPictureFile(File $tmpPictureFile)
    {
        $this->tmpPictureFile = $tmpPictureFile;
        return $this;
    }
}

