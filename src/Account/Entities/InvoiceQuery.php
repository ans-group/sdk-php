<?php

namespace UKFast\SDK\Account\Entities;

use DateTime;

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
     * @var string
     */
    public $resolution;

    /**
     * @var \DateTime
     */
    public $resolutionDate;

    /**
     * @var string
     */
    public $status;

    /**
     * @var \DateTime
     */
    public $date;

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

        $resolutionDate = ($item->resolution_date != null)
            ? DateTime::createFromFormat(DateTime::ISO8601, $item->resolution_date)
            : null;

        $date = ($item->date != null)
            ? DateTime::createFromFormat(DateTime::ISO8601, $item->date)
            : null;

        $this->id = $item->id;
        $this->contactId = $item->contact_id;
        $this->amount = $item->amount;
        $this->whatWasExpected = $item->what_was_expected;
        $this->whatWasReceived = $item->what_was_received;
        $this->proposedSolution = $item->proposed_solution;
        $this->invoiceIds = $item->invoice_ids;
        $this->contactMethod = $item->contact_method;
        $this->resolution = $item->resolution;
        $this->resolutionDate = $resolutionDate;
        $this->date = $date;
        $this->status = $item->status;
    }
}
