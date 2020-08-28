<?php

namespace UKFast\SDK\eCloud;

use UKFast\SDK\Entities\ClientEntityInterface;
use UKFast\SDK\SelfResponse;
use UKFast\SDK\Traits\PageItems;
use UKFast\SDK\eCloud\Entities\LoadBalancerCluster;

class LoadBalancerClusterClient extends Client implements ClientEntityInterface
{
    use PageItems;

    protected $collectionPath = 'v2/lbcs';

    public function getEntityMap()
    {
        return [
            'id' => 'id',
            'vpc_id' => 'vpcId',
            'availability_zone_id' => 'availabilityZoneId',
            'name' => 'name',
            'nodes' => 'nodes',
        ];
    }

    public function loadEntity($data)
    {
        return new LoadBalancerCluster(
            $this->apiToFriendly($data, $this->getEntityMap())
        );
    }

    public function createEntity($entity)
    {
        $response = $this->post(
            $this->collectionPath,
            json_encode($this->friendlyToApi($entity, $this->getEntityMap()))
        );
        $responseBody = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($responseBody))
            ->setClient($this)
            ->serializeWith(function ($responseBody) {
                return $this->loadEntity($responseBody->data);
            });
    }

    public function updateEntity($entity)
    {
        $response = $this->patch(
            $this->collectionPath . '/' . $entity->id,
            json_encode($this->friendlyToApi($entity, $this->getEntityMap()))
        );

        $responseBody = $this->decodeJson($response->getBody()->getContents());

        return (new SelfResponse($responseBody))
            ->setClient($this)
            ->serializeWith(function ($responseBody) {
                return $this->loadEntity($responseBody->data);
            });
    }

    public function deleteById($id)
    {
        $this->delete($this->collectionPath . '/' . $id);
    }
}
