<?php

namespace UKFast\SDK\Account\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $id
 * @property string $companyName
 * @property string $firstName
 * @property string $lastName
 * @property string $emailAddress
 * @property string $createdDate
 */

class Client extends Entity
{
    protected $dates = ['createdDate'];

    public static $entityMap = [
        'id' => 'id',
        'company_name' => 'companyName',
        'first_name' => 'firstName',
        'last_name' => 'lastName',
        'email_address' => 'emailAddress',
        'created_date' => 'createdDate',
    ];
}
