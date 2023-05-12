<?php

namespace UKFast\SDK\Loadbalancers\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $listenerId
 * @property string $vipId
 * @property int $port
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 * @property string $listener_id @deprecated the property listener_id is deprecated, please use listenerId instead
 */
class Bind extends Entity
{
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        if ($this->has('listenerId')) {
            $this->set('listener_id', $this->get('listenerId'));
        }
    }

    protected $dates = [
        'createdAt',
        'updatedAt'
    ];

    public static $entityMap = [
        'listener_id' => 'listenerId',
        'vip_id' => 'vipId',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
