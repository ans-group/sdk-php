<?php

namespace UKFast\SDK\Billing\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $productId
 * @property string $productName
 * @property string $contractId
 * @property string $status
 * @property float $listPrice
 * @property float $salePrice
 * @property float $discountRate
 * @property \DateTime $startedAt
 * @property \DateTime|null $endedAt
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 */
class Subscription extends Entity
{
    protected $dates = ['startedAt', 'endedAt', 'createdAt', 'updatedAt'];

    public static $entityMap = [
        'id' => 'id',
        'product_id' => 'productId',
        'product_name' => 'productName',
        'contract_id' => 'contractId',
        'status' => 'status',
        'list_price' => 'listPrice',
        'sale_price' => 'salePrice',
        'discount_rate' => 'discountRate',
        'started_at' => 'startedAt',
        'ended_at' => 'endedAt',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
    ];
}
