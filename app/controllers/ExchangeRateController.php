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
    {return  $response = $this->exchangeRateService->getData();
        if (false === $this->cache->has("apis")) {
            $response = $this->exchangeRateService->getData();
            $this->cache->set('apis', $response);
        }
        return $this->cache->get('apis');
    }

}

