<?php

namespace Tests\Loadbalancers\Entities;

use PHPUnit\Framework\TestCase;
use UKFast\SDK\Loadbalancers\Entities\Bind;

class BindTest extends TestCase
{
    /**
     * @test
     */
    public function listener_id_property_is_backwards_compatible()
    {
        $bind = new Bind([
            'id' => 1,
            'listenerId' => 123,
            'vipId' => 200,
            'port' => 80,
            'createdAt' => '2022-01-01 10:00:00',
            'updatedAt' => '2022-01-01 10:00:00',
        ]);

        $this->assertEquals(123, $bind->listenerId);
        $this->assertObjectHasAttribute('listener_id', $bind);
        $this->assertEquals(123, $bind->listener_id);
    }
}