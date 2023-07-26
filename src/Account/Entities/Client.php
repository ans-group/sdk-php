<?php

namespace UKFast\SDK\Account\Entities;

use UKFast\SDK\Entity;

/**
 * @property-read int $id
 * @property string $companyName
 * @property string $firstName
 * @property string $lastName
 * @property string $emailAddress
 * @property string $limitedNumber
 * @property int $vatNumber
 * @property string $address
 * @property string $address1
 * @property string $city
 * @property string $county
 * @property string $country
 * @property string $postcode
 * @property string $phone
 * @property string $fax
 * @property string $mobile
 * @property string $type
 * @property string $userName
 * @property string $idReference
 * @property string $nominetContactId
 * @property-read string $createdDate
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
        'limited_number' => 'limitedNumber',
        'vat_number' => 'vatNumber',
        'address' => 'address',
        'address1' => 'address1',
        'city' => 'city',
        'county' => 'county',
        'country' => 'country',
        'postcode' => 'postcode',
        'phone' => 'phone',
        'fax' => 'fax',
        'mobile' => 'mobile',
        'type' => 'type',
        'user_name' => 'userName',
        'id_reference' => 'idReference',
        'nominet_contact_id' => 'nominetContactId',
        'created_date' => 'createdDate',
    ];
}
