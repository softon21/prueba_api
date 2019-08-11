<?php


namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class RestfulResponse
{
    public $code;
    public $body;
}

abstract class BaseController extends Controller
{
    protected function serialize($data, $format = 'json')
    {
        return $this->container->get('jms_serializer')
            ->serialize($data, $format);
    }

    protected function createApiResponse($data, $statusCode = 200)
    {
        $json = $this->serialize($data);
        return new Response($json, $statusCode, array(
            'Content-Type' => 'application/json'
        ));
    }

    protected function getRestful($url, $method, $body = null)
    {
        $response_object = new RestfulResponse;

        $client = new Client([
            'base_uri' => 'http://www.recipepuppy.com/api',
            'timeout' => 10,
            'verify' => false,
            'headers' => ['Content-Type' => 'application/json'],
            'debug' => false,
        ]);

        $arr_body = array();
        if($body != null) {
            foreach ($body AS $k => $b) {
                $arr_body[$k] = $b;
            }
        }
        $json_body = json_encode($arr_body);

        $response = $client->request($method, $url,
            ['body' => $json_body]);

        $response_object->code          = $response->getStatusCode();
        $response_object->body          = $response->getBody()->getContents();

        return $response_object;
    }
}