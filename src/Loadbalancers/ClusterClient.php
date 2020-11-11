<?php

namespace UKFast\SDK\Loadbalancers;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\Loadbalancers\Entities\Cluster;

class ClusterClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/configurations';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
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
        $response = $this->post("v2/deploy?cluster_id=" . $clusterId);
        
        return $response->getStatusCode() < 300;
    }
}
