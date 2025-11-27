<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\eCloud\Entities\Vip;
use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;

class VipClient extends Client implements ClientEntityInterface
{
    /** @use PageItems<Vip> */
    use PageItems;

    protected $collectionPath = 'v2/vips';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'load_balancer_id' => 'loadBalancerId',
            'ip_address_id' => 'ipAddressId',
            'config_id' => 'configId',
            'sync' => 'sync',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function getInternalIp(Vip $vip)
    {
        if (empty($vip->ipAddressId)) {
            return null;
        }

        return $this->ipAddresses()->getById($vip->ipAddressId)->ipAddress;
    }

    public function getFloatingIp(Vip $vip)
    {
        if (!empty($vip->ipAddressId)) {
            $floatingIp = $this->floatingIps()->getAll(['resource_id' => $vip->ipAddressId]);

            if (count($floatingIp) > 0) {
                return $floatingIp[0];
            }
        }

        return null;
    }

    public function loadEntity($data)
    {
        return new Vip(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
}
