<?php

namespace UKFast\SDK\Licenses;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Licenses\Entities\Key;
use UKFast\SDK\Licenses\Entities\License;
use UKFast\SDK\Traits\PageItems;

class LicensesClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v1/licenses';

    public function loadEntity($data)
    {
        return new License(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'owner_id' => 'name',
            'owner_type' => 'ownerType',
            'key_id' => 'keyId',
            'license_type' => 'licenseType',
            'reseller_id' => 'resellerId',
        ];
    }

    /**
     * Revoke a license
     * @param int $id
     * @return bool
     */
    public function revoke($id)
    {
        $response = $this->post($this->collectionPath . '/' . $id . '/revoke');
        return $response->getStatusCode() == 204;
    }

    /**
     * Get a license key
     * @param $id
     * @return Key
     */
    public function key($id)
    {
        $response = $this->get($this->collectionPath . '/' . $id . '/key');
        $body = $this->decodeJson($response->getBody()->getContents());

        return new Key(
            $this->apiToFriendly($body->data, ['key' => 'key'])
        );
    }
}
