<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\Loadbalancers\Entities\Cluster;

class ClusterClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/clusters';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'deployed_at' => 'deployedAt',
            'created_at' => 'createdAt',
            'updated_at' => 'updatedAt',
        ];
    }

    public function loadEntity($data)
    {
        return new Cluster(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }
    
    /**
     * @param string $clusterId
     * @return bool
     */
    public function deploy($clusterId)
    {
        $response = $this->post("v2/clusters/$clusterId/deploy");
        
        return $response->getStatusCode() < 300;
    }
}
