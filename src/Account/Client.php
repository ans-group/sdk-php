<?php

namespace UKFast\Account;

use UKFast\Client as BaseClient;
use UKFast\Page;

class Client extends BaseClient
{
    protected $basePath = 'account';

    /**
     * Gets account details
     *
     * @return Details
     */
    public function getDetails()
    {
        $response = $this->request("GET", "/account/v1/details");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeDetails($body->data);
    }

    /**
     * Gets a paginated response of all Contacts
     *
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return Page
     */
    public function getContacts($page = 1, $perPage = 15, $filters = [])
    {
        $page = $this->paginatedRequest('/account/v1/contacts', $page, $perPage, $filters);
        $page->serializeWith(function ($item) {
            return $this->serializeContact($item);
        });

        return $page;
    }

    /**
     * Gets an individual contact
     *
     * @param string $id
     * @return Contact
     */
    public function getContact($id)
    {
        $response = $this->request("GET", "/account/v1/contacts/$id");
        $body = $this->decodeJson($response->getBody()->getContents());
        return $this->serializeContact($body->data);
    }

    /**
     * Gets account credits
     *
     * @return Details
     */
    public function getCredits()
    {
        $response = $this->request("GET", "/account/v1/credits");
        $body = $this->decodeJson($response->getBody()->getContents());

        return array_map(function ($item) {
            return $this->serializeCredit($item);
        }, $body->data);
    }


    /**
     * Converts a response stdClass into an account Details object
     *
     * @param \stdClass $item
     * @return Details
     */
    protected function serializeDetails($item)
    {
        $details = new Details;
        $details->companyRegistrationNumber = $item->company_registration_number;
        $details->vatIdentificationNumber = $item->vat_identification_number;

        $details->primaryContactId = $item->primary_contact_id;

        return $details;
    }

    /**
     * Converts a response stdClass into a Contact object
     *
     * @param \stdClass $item
     * @return Contact
     */
    protected function serializeContact($item)
    {
        $contact = new Contact;
        $contact->id = $item->id;
        $contact->type = $item->type;

        $contact->firstName = $item->first_name;
        $contact->lastName = $item->last_name;

        return $contact;
    }

    /**
     * Converts a response stdClass into an account Credit object
     *
     * @param \stdClass $item
     * @return Credit
     */
    protected function serializeCredit($item)
    {
        $credit = new Credit;
        $credit->type = $item->type;
        $credit->total = $item->total;
        $credit->remaining = $item->remaining;

        return $credit;
    }
}
