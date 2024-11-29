<?php

namespace App\Http\Api\List;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Symfony\Component\HttpFoundation\Response;

class ListController extends Controller
{
protected Client $client;

    /**
     * @param Client $client
     */
    public function __construct()
    {
        $this->client = new Client(
            [
                "base_uri" =>env('API_LIST')
            ]
        );
    }


    public function index(){
        try{
            parse_str(request()->getQueryString(),$query);
            $request = $this->client->get('breweries',[
                "query" => $query
            ]);
            if($request->getStatusCode() >= 300)
                throw new \Exception("Impossibile procedere con la richiesta", $request->getStatusCode());

            $response = json_decode($request->getBody()->getContents());
            return (new ListCollection($response))->response(request())->setStatusCode(Response::HTTP_OK);

        }catch (\Exception|ServerException|GuzzleException|ClientException $e){
            throw new \Exception($e->getMessage(),Response::HTTP_UNPROCESSABLE_ENTITY);
        }

    }

}
