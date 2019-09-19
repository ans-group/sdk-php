<?php

namespace Tests\Pss;

use PHPUnit\Framework\TestCase;
use UKFast\SDK\PSS\Entities\Product;

class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function constructs_from_response()
    {
        $product = new Product((object)[
            'id' => 100,
            'type' => 'Domains',
        ]);

        $this->assertEquals(100, $product->id);
        $this->assertEquals('Domains', $product->type);
    }
}
