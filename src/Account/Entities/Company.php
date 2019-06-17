<?php

namespace UKFast\Account\Entities;

class Company
{
    public $companyRegistrationNumber;
    public $vatIdentificationNumber;

    public $primaryContactId;


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
    }
}
