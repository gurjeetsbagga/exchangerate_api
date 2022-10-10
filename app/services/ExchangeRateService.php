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
    public function getData($currency = "USD")
    {
        $url = $this->config->get('api')->get('exchangeRate')->get('url');
        $key = $this->config->get('api')->get('exchangeRate')->get('key');
        $currencies = $this->config->get('currencies')->toArray();
        $all = (isset($currencies) && count($currencies) > 0) ? false: true;

        $req_url = "$url/$key/latest/$currency";
        $response_json = file_get_contents($req_url);

        $object = new \stdClass();
        if(false !== $response_json) {

            $response = json_decode($response_json);
            $conversionRate = [];
            if ('success' === $response->result) {
                if(!$all) {
                    foreach ($response->conversion_rates as $key=>$value) {
                        if (in_array($key, $currencies)) {
                            $conversionRate[$key] = $value;
                        }
                    }
                }else{
                    foreach ($response->conversion_rates as $key=>$value) {
                        $conversionRate[$key] = $value;
                    }
                }
            }
        }
        $symbols = $this->getSymbolData($all);
        $object->base_code = $response->base_code;
        $object->conversion_rates = $conversionRate;
        $object->symbols = $symbols;
        return $object;
    }

    public function getSymbolData()
    {
        $url = $this->config->get('api')->get('exchangeRate')->get('url');
        $key = $this->config->get('api')->get('exchangeRate')->get('key');
        $currencies = $this->config->get('currencies')->toArray();

        $all = (isset($currencies) && count($currencies) > 0) ? false: true;
        $req_url = "$url/$key/codes";
        $response_json = file_get_contents($req_url);
        $supportedCodes = json_decode($response_json);

        $symbols = [];
        if('success' === $supportedCodes->result) {
            if (!$all) {
                foreach ($supportedCodes->supported_codes as $supportedCode) {
                    if (in_array($supportedCode[0], $currencies)) {
                        $symbols[$supportedCode[0]] = $supportedCode[1];
                    }
                }
            }else {
                foreach ($supportedCodes->supported_codes as $supportedCode) {
                        $symbols[$supportedCode[0]] = $supportedCode[1];
                }
            }
        }

        return $symbols;
    }
}