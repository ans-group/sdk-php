<?php

namespace UKFast\SDK\Account;

use UKFast\SDK\Account\Entities\Client as ClientEntity;
use UKFast\SDK\Client as BaseClient;
use UKFast\SDK\Traits\PageItems;

class ClientClient extends BaseClient
{
    use PageItems;

    protected $basePath = 'v1/clients/';

    /**
     * @param $data
     * @return ClientEntity
     */
    public function loadEntity($data)
    {
        return new ClientEntity(
            $this->apiToFriendly($data, ClientEntity::$entityMap)
        );
    }

    /**
     * @param $id
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @deprecated please use ClientClient::deleteById()
     */
    public function destroy($id)
    {
        return $this->deleteById($id);
    }


}
