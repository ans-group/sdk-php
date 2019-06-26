<?php

namespace UKFast\PSS;

use UKFast\Client as BaseClient;

class Client extends BaseClient
{
    protected $basePath = 'pss/';
    
    /**
     * @return \UKFast\PSS\RequestClient
     */
    public function requests()
    {
        return (new RequestClient($this->httpClient))->auth($this->token);
    }

    /**
     * @return \UKFast\PSS\ConversationClient
     */
    public function conversation()
    {
        return (new ConversationClient($this->httpClient))->auth($this->token);
    }
}
