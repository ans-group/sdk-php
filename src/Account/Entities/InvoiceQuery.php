<?php

namespace UKFast\SDK\Account\Entities;

class InvoiceQuery
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $contact_id;

    /**
     * @var int
     */
    public $amount;

    /**
     * @var string
     */
    public $what_was_expected;

    /**
     * @var string
     */
    public $what_was_received;

    /**
     * @var string
     */
    public $proposed_solution;

    /**
     * @var array
     */
    public $invoice_ids;

    /**
     * InvoiceQuery constructor.
     * 
     * @param null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->id = $item->id;
        $this->contactId = $item->contact_id;
        $this->amount = $item->amount;
        $this->whatWasExpected = $item->what_was_expected;
        $this->whatWasReceived = $item->what_was_received;
        $this->proposedSolution = $item->proposed_solution;
        $this->invoiceIds = $item->invoice_ids;
    }
}
