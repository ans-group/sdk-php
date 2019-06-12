<?php

namespace UKFast\PSS;

use UKFast\Client as BaseClient;

class Client extends BaseClient
{
    /**
     * @return \UKFast\PSS\RequestClient
     */
    public function requests()
    {
        return (new RequestClient($this->httpClient));
    }

    /**
     * @return \UKFast\PSS\ConversationClient
     */
    public function conversation()
    {
        return (new ConversationClient($this->httpClient));
    }
}
