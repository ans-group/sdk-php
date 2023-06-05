<?php

namespace UKFast\SDK\Account;

use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\Account\Entities\Client;

class ClientClient extends BaseClient
{
    use PageItems;

    protected $basePath = 'v1/clients/';

    public function getEntityMap()
    {
        return Client::$entityMap;
    }

    public function loadEntity($data)
    {
        return new Client(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    /**
     * @param $id
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function destroy($id)
    {
        return $this->deleteById($id);
    }
}
