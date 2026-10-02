<?php

namespace UKFast\SDK\Domains;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Domains\Entities\Settings;

class SettingsClient extends BaseClient
{
    protected $basePath = 'registrar/';

    /**
     * Settings API fields which need mapping
     *
     * @var array
     */
    public $settingsMap = [
        'nameserver_one' => 'nameserverOne',
        'nameserver_two' => 'nameserverTwo',
        'nameserver_three' => 'nameserverThree',
        'auto' => 'autoRenew',
        'auto_term' => 'autoRenewTerm',
    ];

    /**
     * Gets the account's domain settings
     *
     * @return Settings
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSettings()
    {
        $response = $this->get('v2/settings');
        $body = $this->decodeJson($response->getBody()->getContents());
        $data = $body->data;

        $attributes = [];

        if (isset($data->registration)) {
            $attributes = array_merge($attributes, (array) $data->registration);
        }

        if (isset($data->renewal)) {
            $attributes = array_merge($attributes, (array) $data->renewal);
        }

        return new Settings($this->apiToFriendly($attributes, $this->settingsMap));
    }

    /**
     * Updates the account's domain settings. Only the attributes set on
     * $settings are sent, so a setting can be changed without touching the
     * rest; a nameserver set to null is cleared. With nothing set, no
     * request is made.
     *
     * @param Settings $settings
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(Settings $settings)
    {
        $attributes = $settings->all();
        $data = [];

        foreach (['nameserverOne', 'nameserverTwo', 'nameserverThree'] as $attribute) {
            if (array_key_exists($attribute, $attributes)) {
                $data['registration'][array_search($attribute, $this->settingsMap)] = $attributes[$attribute];
            }
        }

        foreach (['autoRenew', 'autoRenewTerm'] as $attribute) {
            if (array_key_exists($attribute, $attributes)) {
                $data['renewal'][array_search($attribute, $this->settingsMap)] = $attributes[$attribute];
            }
        }

        if (empty($data)) {
            return true;
        }

        $this->patch('v2/settings', json_encode($data));

        return true;
    }
}
