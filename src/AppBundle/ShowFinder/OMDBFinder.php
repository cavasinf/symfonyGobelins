<?php

namespace AppBundle\ShowFinder;

use AppBundle\Entity\Category;
use AppBundle\Entity\Show;
use GuzzleHttp\Client;

/**
 * @property Client client
 */
class OMDBFinder implements ShowFinderInterface
{

//    apikey = 3ef04561

    private $client;
    private $apiKey;


    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client([
            'base_uri' => "http://www.omdbapi.com/",
        ]);
    }


    /**
     * @param String $query
     * @return array $result
     * array of shows in according to the query
     */
    public function findByName($query = '')
    {
        $res = $this->client->get('', [
            'query' => [
                'apikey' => $this->apiKey,
                's' => $query,
                'type' => 'series',
                'plot' => 'full'
            ]
        ]);

        $series = \GuzzleHttp\json_decode($res->getBody(), 1)['Search'];
        foreach ($series as &$serie) {
            $serie = $this->getShowInfo($serie['imdbID']);
            $serie = $this->castApiShow($serie);
        }

        return $series;
    }

    /**
     * @return String $name
     */
    public function getName()
    {
        return 'OMDB API';
    }

    private function getShowInfo($imdbID)
    {
        $res = $this->client->get('', [
            'query' => [
                'apikey' => $this->apiKey,
                'i' => $imdbID,
                'type' => 'series'
            ]
        ]);
        return \GuzzleHttp\json_decode($res->getBody(), 1);
    }

    private function castApiShow($apiShow){
        $category = new Category();
        $category->setName($apiShow["Genre"]);

        $show = new Show();
        $show->setName($apiShow["Title"]);
        $show->setAbstract($apiShow["Plot"]);
        $show->setCountry($apiShow["Country"]);
        $show->setReleaseDate($apiShow["Released"]);
        $show->setAuthor($apiShow["Writer"]);
        $show->setMainPicture($apiShow["Poster"]);
        $show->setCategory($category);

        return $show;
    }
}