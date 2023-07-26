<?php

namespace UKFast\SDK\Account;

use UKFast\SDK\Account\Entities\AvailableRegistrantType;
use UKFast\SDK\Account\Entities\Client as ClientEntity;
use UKFast\SDK\Traits\PageItems;

class ClientClient extends Client
{
    use PageItems;

    protected $collectionPath = 'v1/clients';

    /**
     * @param $data
     * @return ClientEntity
     */
    public function loadEntity($data)
    {
        return new ClientEntity(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function getEntityMap()
    {
        return ClientEntity::$entityMap;
    }

    /**
     * @param $data
     * @return AvailableRegistrantType
     */
    public function loadAvailableRegistrantTypeEntity($data)
    {
        return new AvailableRegistrantType(
            $this->apiToFriendly($data, AvailableRegistrantType::$entityMap)
        );
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAvailableRegistrantTypes()
    {
        $response = $this->get($this->collectionPath . '/available-registrant-types');
        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return $this->loadAvailableRegistrantTypeEntity($item);
        }, $body->data);
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
