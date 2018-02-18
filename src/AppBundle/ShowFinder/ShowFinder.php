<?php

namespace AppBundle\ShowFinder;

class ShowFinder
{
    private $finders;

    /**
     * @param $query
     * @return array
     */
    public function findByName($query){
        $results = [];

        /** @var ShowFinderInterface $finder */
        foreach($this->finders as $finder){
            $results = array_merge($results, $finder->findByName($query));
        }

        return $results;
    }

    /**
     * @param ShowFinderInterface $finder
     */
    public function addFinder(ShowFinderInterface $finder){
        $this->finders[] = $finder;
    }
}