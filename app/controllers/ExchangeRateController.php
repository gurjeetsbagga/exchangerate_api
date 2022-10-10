<?php
declare(strict_types=1);

namespace App\Controllers;
use App\Services\ExchangeRateService;

class ExchangeRateController extends AbstractController
{

    /**
     * @var
     */
    protected $exchangeRateService;


    public function onConstruct()
    {
        $this->exchangeRateService = new ExchangeRateService();
    }

    /**
     * @return mixed
     */
    public function getExchangeRateAction()
    {
       $response = $this->exchangeRateService->getData();
       exit(json_encode($response));
        if (!$this->cache->has("apis")) {
            $this->cache->set('apis', $response);
        }
        return $this->cache->get('apis');
    }

}

