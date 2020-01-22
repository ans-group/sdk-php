<?php

namespace UKFast\SDK\Account\Entities;

class Company
{
    /**
     * @var string
     */
    public $companyRegistrationNumber;

    /**
     * @var string
     */
    public $vatIdentificationNumber;

    /**
     * @var int
     */
    public $primaryContactId;

    /**
     * @var boolean
     */
    public $isDemoAccount;

    /**
     * @var string
     */
    public $name;
    
    /**
     * @var string
     */
    public $country;

    /**
     * Company constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->companyRegistrationNumber = $item->company_registration_number;
        $this->vatIdentificationNumber = $item->vat_identification_number;

        $this->primaryContactId = $item->primary_contact_id;
        $this->isDemoAccount = $item->is_demo_account;

        $this->name = $item->name;
        
        $this->country = $item->country;
    }
}
