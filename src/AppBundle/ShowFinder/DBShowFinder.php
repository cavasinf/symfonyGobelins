<?php

namespace AppBundle\ShowFinder;


use AppBundle\Repository\ShowRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DBShowFinder implements ShowFinderInterface
{

    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return String $name
     */
    public function getName()
    {
        return 'Database';
    }

    /**
     * @param String $query
     * @return array $result
     * array of shows in according to the query
     */
    public function findByName($query)
    {
        /** @var ShowRepository $showRepository */
        $showRepository = $this->doctrine->getRepository('AppBundle:Show');
        return $showRepository->findAllByQuery($query);
    }
}