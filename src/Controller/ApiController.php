<?php


namespace App\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as FOSRest;


/**
 * Brand controller.
 *
 * @Route("/api")
 */
class ApiController extends BaseController
{
    /**
     * Lists recipes
     * @FOSRest\Get("/recipes/{type}")
     * @param $type
     *
     * @return Response
     */
    public function listRecipesAction($type)
    {
        //GET DATA FROM EXTERNAL API
        $response_object = $this->getRestful('', 'GET');

        return $this->generateResponse($response_object);
    }

    /**
     * Find recipes by keyword
     * @FOSRest\Get("/recipes/find/{word}")
     * @param $word
     *
     * @return Response
     */
    public function findRecipesAction($word)
    {
        //GET DATA FROM EXTERNAL API
        $response_object = $this->getRestful('?q=' . $word, 'GET');

        return $this->generateResponse($response_object);
    }

    /*
     * THIS FUNCTION WILL GENERATE THE RESPONSE, PARSED TO JSON
     */
    private function generateResponse(RestfulResponse $restfulResponse)
    {
        //IF 200, GET THE RESULTS AND CREATE RESPONSE
        if($restfulResponse->code == 200)
        {
            $ar = json_decode($restfulResponse->body, true);
            $results = $ar['results'];
            $response = $this->createApiResponse($results, 200);
        }
        //ELSE, SEND ERROR
        else
        {
            $ar = array(
                "error_code" => "01",
                "error_msg" => "Error extracting recipes from api"
            );
            $response = $this->createApiResponse($ar, 500);
        }

        return $response;
    }
}