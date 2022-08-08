<?php

namespace UKFast\SDK\Account\Entities;

class Contact
{
    public $id;
    public $type;

    public $firstName;
    public $lastName;
    public $emailAddress;
    public $mobile;

    public $monitoringAlertsEmail;
    public $thresholdMonitoringAlertsEmail;
    public $monitoringAlertsSms;
    public $thresholdMonitoringAlertsSms;

    /**
     * Contact constructor.
     * @param \stdClass|null $item
     */
    public function __construct($item = null)
    {
        if (empty($item)) {
            return;
        }

        $this->id = $item->id;
        $this->type = $item->type;

        $this->firstName = $item->first_name;
        $this->lastName = $item->last_name;
        $this->emailAddress = $item->email_address;
        $this->mobile = $item->mobile;

        $this->monitoringAlertsEmail = $item->monitoring_alerts_email;
        $this->thresholdMonitoringAlertsEmail = $item->threshold_monitoring_alerts_email;
        $this->monitoringAlertsSms = $item->monitoring_alerts_sms;
        $this->thresholdMonitoringAlertsSms = $item->threshold_monitoring_alerts_sms;
    }

    /**
     * @return string
     */
    public function fullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
