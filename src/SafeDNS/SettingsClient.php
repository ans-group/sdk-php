<?php

namespace UKFast\SDK\SafeDNS;

use UKFast\SDK\SafeDNS\Entities\CustomAxfr;
use UKFast\SDK\SafeDNS\Entities\Nameserver;
use UKFast\SDK\SafeDNS\Entities\Settings;

class SettingsClient extends Client
{
    public static $settingsMap = [
        'custom_soa_allowed'     => 'customSoaAllowed',
        'custom_base_ns_allowed' => 'customBaseNsAllowed',
        'custom_axfr'            => 'customAxfr',
        'delegation_allowed'     => 'delegationAllowed'
    ];

    public static $nameserverMap = [];

    public static $customAxfrMap = [];

    /**
     * Get the safeDNS settings
     * @return \Psr\Http\Message\ResponseInterface|Settings
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAll()
    {
        $response = $this->get('v1/settings');
        $body     = $this->decodeJson($response->getBody()->getContents());

        return $this->loadEntity($body->data);
    }

    /**
     * @param $data
     * @return Settings
     */
    public function loadEntity($data)
    {
        $settings = new Settings($this->apiToFriendly($data, static::$settingsMap));

        $nameservers = [];
        foreach ($settings->nameservers as $nameserver) {
            $nameservers[] = new Nameserver($this->apiToFriendly($nameserver, static::$nameserverMap));
        }

        $settings->nameservers = $nameservers;
        $settings->customAxfr = new CustomAxfr($this->apiToFriendly($settings->customAxfr, static::$customAxfrMap));

        $settings->syncOriginalAttributes();

        return $settings;
    }
}
