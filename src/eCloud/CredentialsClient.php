<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\Credentials;
use UKFast\SDK\Entities\ClientEntityInterface;

class CredentialsClient extends Client implements ClientEntityInterface
{
    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'resource_id' => 'resourceId',
            'user' => 'username',
            'password' => 'password',
            'host' => 'hostname',
            'port' => 'port',
        ];
    }

    public function loadEntity($data)
    {
        return new Credentials(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
