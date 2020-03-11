<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\ThreatMonitoring;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'threat-monitoring/';

    /**
     * @return BaseClient
     */
    public function alerts()
    {
        return (new AlertClient($this->httpClient))->auth($this->token);
    }
}
