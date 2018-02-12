<?php

namespace AppBundle\ShowFinder;

interface ShowFinderInterface {

    /**
     * @param String $query
     * @return array $result
     * array of shows in according to the query
     */
    public function findByName($query);

    /**
     * @return String $name
     */
    public function getName();

}