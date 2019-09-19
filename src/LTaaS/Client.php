<?php

namespace UKFast\SDK\LTaaS;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'ltaas/';

    /**
     * @return BaseClient
     */
    public function domains()
    {
        return (new DomainClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function jobs()
    {
        return (new JobClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function tests()
    {
        return (new TestClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function scenarios()
    {
        return (new ScenarioClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function thresholds()
    {
        return (new ThresholdClient($this->httpClient))->auth($this->token);
    }

    public function agreements()
    {
        return (new AgreementClient($this->httpClient))->auth($this->token);
    }
}
