<?php

namespace UKFast\SDK\Domains\Entities;

use UKFast\SDK\Entity;

/**
 * @property string $name
 * @property int $period
 * @property array|null $nameservers
 * @property bool|null $autoRenew
 * @property DomainRegistrant|null $registrant
 */
class DomainRegistration extends Entity
{
    /**
     * @return array
     */
    public function toApiArray()
    {
        $data = [
            'name' => $this->name,
            'period' => $this->period,
        ];

        if (!is_null($this->nameservers)) {
            $data['nameservers'] = $this->nameservers;
        }

        if (!is_null($this->autoRenew)) {
            $data['renewal'] = ['auto' => $this->autoRenew];
        }

        if (!is_null($this->registrant)) {
            $data['registrant'] = $this->serialiseRegistrant($this->registrant);
        }

        return $data;
    }

    /**
     * @param DomainRegistrant $registrant
     * @return array
     */
    private function serialiseRegistrant($registrant)
    {
        $data = [];

        if (!is_null($registrant->nominetId)) {
            $data['nominet_id'] = $registrant->nominetId;
        }

        if (!is_null($registrant->name)) {
            $data['name'] = $registrant->name;
        }

        if (!is_null($registrant->type)) {
            $data['type'] = $registrant->type;
        }

        if (!is_null($registrant->privacy)) {
            $data['privacy'] = $registrant->privacy;
        }

        if (!is_null($registrant->company)) {
            $company = $registrant->company;
            $companyData = [];

            if (!is_null($company->number)) {
                $companyData['number'] = $company->number;
            }

            if (!is_null($company->tradingAs)) {
                $companyData['trading_as'] = $company->tradingAs;
            }

            if (!empty($companyData)) {
                $data['company'] = $companyData;
            }
        }

        if (!is_null($registrant->contact)) {
            $contact = $registrant->contact;
            $contactData = [
                'name' => $contact->name,
                'email' => $contact->email,
            ];

            if (!is_null($contact->phone)) {
                $contactData['phone'] = $contact->phone;
            }

            $data['contact'] = $contactData;
        }

        if (!is_null($registrant->address)) {
            $address = $registrant->address;
            $addressData = [
                'line1' => $address->line1,
                'city' => $address->city,
                'postcode' => $address->postcode,
                'country' => $address->country,
            ];

            if (!is_null($address->line2)) {
                $addressData['line2'] = $address->line2;
            }

            if (!is_null($address->county)) {
                $addressData['county'] = $address->county;
            }

            $data['address'] = $addressData;
        }

        return $data;
    }
}
