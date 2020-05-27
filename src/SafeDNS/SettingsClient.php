<?php

namespace UKFast\SDK\SafeDNS;

use UKFast\SDK\SafeDNS\Entities\Settings;

class SettingsClient extends Client
{
    const SETTINGS_MAP = [
        'custom_soa_allowed' => 'customSoaAllowed',
        'custom_base_ns_allowed' => 'customBaseNsAllowed',
        'custom_axfr' => 'customAxfr',
        'delegation_allowed' => 'delegationAllowed'
    ];

    /**
     * Get the safeDNS settings
     * @return \Psr\Http\Message\ResponseInterface|Settings
     */
    public function getAll()
    {
        $response = $this->get('v1/settings');
        $body = $this->decodeJson($response->getBody()->getContents());

        return new Settings($this->apiToFriendly($body->data, self::SETTINGS_MAP));
    }
}
