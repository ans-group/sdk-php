<?php

namespace UKFast\PHaaS;

use UKFast\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'phaas/';

    /**
     * @return BaseClient
     */
    public function domains()
    {
        return (new DomainClient())->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function users()
    {
        return (new UserClient())->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function groups()
    {
        return (new GroupClient())->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function templates()
    {
        return (new TemplateClient())->auth($this->token);
    }

    /**
     * @return BaseClient
     */
    public function campaigns()
    {
        return (new CampaignClient())->auth($this->token);
    }
}
