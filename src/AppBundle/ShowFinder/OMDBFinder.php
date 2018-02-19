<?php

namespace AppBundle\ShowFinder;

use AppBundle\Entity\Category;
use AppBundle\Entity\Show;
use DateTime;
use GuzzleHttp\Client;

/**
 * @property Client client
 */
class OMDBFinder implements ShowFinderInterface
{

//    apikey = 3ef04561

    private $client;
    private $apiKey;


    public function __construct($client,$apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
        /*$this->client = new Client([
            'base_uri' => "http://www.omdbapi.com/",
        ]);*/
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

        $JSONResponse = \GuzzleHttp\json_decode($res->getBody(), 1);
        if (isset($JSONResponse["Error"]))
            return [];
        $series = $JSONResponse['Search'];
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

    private function castApiShow($apiOMDBShow){

        $category = new Category();
        $category->setName($apiOMDBShow["Genre"]);

        $show = new Show();
        $show->setName($apiOMDBShow["Title"]);
        $show->setDataSource(Show::CST_DATA_SOURCE_OMDB);
        $show->setAbstract($apiOMDBShow["Plot"]);
        $show->setCountry($apiOMDBShow["Country"]);
        $show->setReleaseDate($apiOMDBShow["Released"]);
        $show->setAuthor($apiOMDBShow["Writer"]);
        $show->setMainPicture($apiOMDBShow["Poster"]);
        $show->setCategory($category);

        return $show;
    }
}