<?php

namespace UKFast\SDK\Account;

use UKFast\SDK\Account\Entities\AvailableRegistrantType;
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
     * @return AvailableRegistrantType
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAvailableRegistrantTypes()
    {
        $response = $this->get($this->basePath . 'available-registrant-types');
        $body = $this->decodeJson($response->getBody()->getContents());

        return $this->loadAvailableRegistrantTypeEntity($body->data);
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
