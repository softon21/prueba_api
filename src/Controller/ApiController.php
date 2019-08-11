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

        //IF 200, GET THE RESULTS AND CREATE RESPONSE
        if($response_object->code == 200)
        {
            $ar = json_decode($response_object->body, true);
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