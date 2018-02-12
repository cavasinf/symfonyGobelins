<?php

namespace AppBundle\ShowFinder;

use GuzzleHttp\Client;

/**
 * @property Client client
 */
class OMDBFinder implements ShowFinderInterface
{

//    apikey = 3ef04561

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param String $query
     * @return array $result
     * array of shows in according to the query
     */
    public function findByName($query)
    {
        $results = $this->client->get('/?apikey=3ef04561&i=tt3896198');
        dump(\GuzzleHttp\json_decode($results->getBody(),true));
    }

    /**
     * @return String $name
     */
    public function getName()
    {
        return 'IMDB API';
    }
}