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
    public $contactId;

    /**
     * @var int
     */
    public $amount;

    /**
     * @var string
     */
    public $whatWasExpected;

    /**
     * @var string
     */
    public $whatWasReceived;

    /**
     * @var string
     */
    public $proposedSolution;

    /**
     * @var array
     */
    public $invoiceIds;

    /**
     * @var string
     */
    public $contactMethod;

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
        $this->contactMethod = $item->contact_method;
    }
}
