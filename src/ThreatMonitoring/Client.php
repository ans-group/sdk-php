<?php
/**
 * @author: John Birch-Evans <john.birch-evans@ukfast.co.uk>
 * @copyright: 2020 UKFast.net Ltd
 */

namespace UKFast\SDK\ThreatMonitoring;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\ThreatMonitoring\Reporting\AttackGeolocationClient;
use UKFast\SDK\ThreatMonitoring\Reporting\AttackingIpsClient;
use UKFast\SDK\ThreatMonitoring\Reporting\BlockedAttacksClient;
use UKFast\SDK\ThreatMonitoring\Reporting\EventsClient;
use UKFast\SDK\ThreatMonitoring\Reporting\TopAlertsClient;
use UKFast\SDK\ThreatMonitoring\Reporting\TopFilesChangedClient;

class Client extends BaseClient
{
    protected $basePath = 'threat-monitoring/';

    /**
     * @return AgentClient
     */
    public function agents()
    {
        return (new AgentClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return AlertClient
     */
    public function alerts()
    {
        return (new AlertClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return UserClient
     */
    public function users()
    {
        return (new UserClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return SecurityScanClient
     */
    public function scans()
    {
        return (new SecurityScanClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return TargetClient
     */
    public function targets()
    {
        return (new TargetClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return EventsClient
     */
    public function eventReports()
    {
        return (new EventsClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BlockedAttacksClient
     */
    public function blockedAttackReports()
    {
        return (new BlockedAttacksClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return AttackingIpsClient
     */
    public function attackingIpReports()
    {
        return (new AttackingIpsClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return TopAlertsClient
     */
    public function topAlertReports()
    {
        return (new TopAlertsClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return TopFilesChangedClient
     */
    public function topFilesChangedReports()
    {
        return (new TopFilesChangedClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return AttackGeolocationClient
     */
    public function attackGeolocationReports()
    {
        return (new AttackGeolocationClient($this->httpClient))->auth($this->token);
    }
}
