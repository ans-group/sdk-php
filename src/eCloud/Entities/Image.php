<?php

namespace UKFast\SDK\eCloud\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $logoUri
 * @property string $documentationUri
 * @property string $createdAt
 * @property string $updatedAt
 */
class Image extends Entity
{
    protected $dates = ['createdAt', 'updatedAt'];
}
