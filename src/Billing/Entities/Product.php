<?php

namespace UKFast\SDK\Billing\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $category
 * @property string $subcategory
 * @property string $service
 * @property string $status
 * @property float $floorPrice
 * @property float $listPrice
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 */
class Product extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'name' => 'name',
        'category' => 'category',
        'subcategory' => 'subcategory',
        'service' => 'service',
        'status' => 'status',
        'floor_price' => 'floorPrice',
        'list_price' => 'listPrice',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
