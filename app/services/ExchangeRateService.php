<?php

namespace App\Services;

use function PHPUnit\Framework\throwException;

/**
 * business logic for ExchangeRate
 *
 * Class ExchangeRateService
 */
class ExchangeRateService extends AbstractService
{

    /**
     * @param string $country
     * @return false|mixed
     */
    public function getData(string $country="USD")
    {
        $url = $this->config->get('api')->get('exchangeRate')->get('url');
        $key = $this->config->get('api')->get('exchangeRate')->get('key');
        $req_url = "$url/$key/latest/$country";
        $response_json = file_get_contents($req_url);

        if(false !== $response_json) {
            $response = json_decode($response_json);
            if ('success' !== $response->result) {
                return false;
            }
        }
        return $response;
    }

}