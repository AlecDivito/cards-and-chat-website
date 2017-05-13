<?php
/**
 * Created by PhpStorm.
 * User: Alec Divito
 * Date: 13/05/17
 * Time: 12:07 AM
 */

namespace App\Repositories;


use GuzzleHttp\Client;

abstract class AbstractAPIRepository
{
    protected $url;

    protected function sendRequest($fullUrl = '', $options = [])
    {
        $client = new Client();

        $response = $client->get($fullUrl, ['query' => $options]);

        if($response->getStatusCode() == '200' OR '201')
        {
            return $response->getBody()->getContents();
        }

        throw new \HttpRequestException($response->getStatusCode() . ' status code returned');
    }
}