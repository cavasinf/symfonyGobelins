<?php

namespace AppBundle\ShowFinder;

class ShowFinder {

    private $finders;

    private $showFinders;

    /**
     * @param $query
     * @return array
     */
    public function findByName($query) {

        $tmp = [];

        /** @var ShowFinderInterface $finder */
        foreach ($this->finders as $finder) {
            $tmp[$finder->getName()] = $finder->findByName($query);
        }

        return $tmp;
    }

    /**
     * @param $finder
     */
    public function addFinder($finder) {
            $this->showFinders[]=$finder;
    }

}