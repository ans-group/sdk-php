<?php

namespace UKFast\SDK\Billing\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property object{
 *     id: string,
 *     name: string
 * } $product
 * @property object{
 *     id: string
 * } $contract
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
        'product' => 'product',
        'contract' => 'contract',
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
