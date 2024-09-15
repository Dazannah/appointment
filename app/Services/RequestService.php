<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Interfaces\IRequest;

class RequestService implements IRequest {

  public function getHolidays($year): array | false {
    $apiKey = env('SZUNETNAPOK_API');
    $ssl = env('APP_ENV', 'production') == 'local' ? false : true;

    $client = new Client([
      'base_uri' => "https://szunetnapok.hu",
      'verify' => $ssl,
    ]);


    $response = $client->request('GET', "/api/$apiKey/$year");

    if ($response->getStatusCode() == 200) {
      $response = json_decode($response->getBody()->getContents(), true);

      return $response;
    } else
      return ['response' => 'Error', 'message' => 'The API request failed'];
  }
}
