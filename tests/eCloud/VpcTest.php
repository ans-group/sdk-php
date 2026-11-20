<?php

namespace Tests\eCloud;

use PHPUnit\Framework\TestCase;
use UKFast\SDK\eCloud\Entities\Vpc;
use UKFast\SDK\eCloud\VpcClient;

class VpcTest extends TestCase
{
    /**
     * @test
     */
    public function itHydratesTheVpcLockState()
    {
        $vpc = (new VpcClient())->loadEntity([
            'id' => 'vpc-1',
            'locked' => true,
        ]);

        $this->assertInstanceOf(Vpc::class, $vpc);
        $this->assertTrue($vpc->locked);
    }
}
