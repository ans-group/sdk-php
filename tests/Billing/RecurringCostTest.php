<?php

namespace Tests\Billing;

use PHPUnit\Framework\TestCase;
use UKFast\SDK\Billing\Entities\RecurringCost;

class RecurringCostTest extends TestCase
{
    /**
     * @test
     */
    public function frequency_can_return_monthly()
    {
        $recurringCost = new RecurringCost;
        $recurringCost->period = 'month';
        $recurringCost->interval = 1;

        $this->assertEquals('Monthly', $recurringCost->frequency());
    }

    /**
     * @test
     */
    public function frequency_can_return_quarterly()
    {
        $recurringCost = new RecurringCost;
        $recurringCost->period = 'month';
        $recurringCost->interval = 3;

        $this->assertEquals('Quarterly', $recurringCost->frequency());
    }

    /**
     * @test
     */
    public function frequency_can_return_yearly()
    {
        $recurringCost = new RecurringCost;
        $recurringCost->period = 'year';
        $recurringCost->interval = 1;

        $this->assertEquals('Yearly', $recurringCost->frequency());
    }

    /**
     * @test
     */
    public function frequency_can_return_every_x_months()
    {
        $recurringCost = new RecurringCost;
        $recurringCost->period = 'month';
        $recurringCost->interval = 5;

        $this->assertEquals('Every 5 Months', $recurringCost->frequency());
    }

    /**
     * @test
     */
    public function frequency_can_return_every_x_years()
    {
        $recurringCost = new RecurringCost;
        $recurringCost->period = 'year';
        $recurringCost->interval = 5;

        $this->assertEquals('Every 5 Years', $recurringCost->frequency());
    }
}
