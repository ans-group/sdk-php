<?php

namespace UKFast\SDK\SafeDNS;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'safedns/';


    /**
     * @return BaseClient
     */
    public function zones()
    {
        return (new ZoneClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function records()
    {
        return (new RecordClient($this->httpClient))->auth($this->token);
    }

    /**
     * Shortcut to get a NoteClient
     *
     * @return BaseClient
     */
    public function notes()
    {
        return (new NoteClient($this->httpClient))->auth($this->token);
    }

    /**
     * Shortcut to get a TemplateClient
     *
     * @return BaseClient
     */
    public function templates()
    {
        return (new TemplateClient($this->httpClient))->auth($this->token);
    }

    /**
     * Shortcut to get a SettingsClient
     *
     * @return SettingsClient
     */
    public function settings()
    {
        return (new SettingsClient($this->httpClient))->auth($this->token);
    }
}
