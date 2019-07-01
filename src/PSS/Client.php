<?php

namespace UKFast\SDK\PSS;

use UKFast\SDK\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'pss/';
    
    /**
     * @return \UKFast\SDK\PSS\RequestClient
     */
    public function requests()
    {
        return (new RequestClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return \UKFast\SDK\PSS\ConversationClient
     */
    public function conversation()
    {
        return (new ConversationClient($this->httpClient))->auth($this->token);
    }
}
