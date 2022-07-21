<?php

namespace Tests\Domains;

use PHPUnit\Framework\TestCase;
use UKFast\SDK\Domains\WhoisClient;

class WhoisTest extends TestCase
{
    /**
     * @test
     * @dataProvider domainsToSanitise
     */
    public function testSanitisesDomains($unsanitised, $sanitised)
    {
        $this->assertEquals($sanitised, (new WhoisClient())->sanitiseDomain($unsanitised));
    }

    public function domainsToSanitise()
    {
        return [
            [
                'unsanitised' => 'http://foo.bar',
                'sanitised' => 'foo.bar',
            ],
            [
                'unsanitised' => 'https://foo.bar',
                'sanitised' => 'foo.bar',
            ],
            [
                'unsanitised' => 'http:/foo.bar',
                'sanitised' => 'foo.bar',
            ],
            [
                'unsanitised' => 'https:/foo.bar',
                'sanitised' => 'foo.bar',
            ],
            [
                'unsanitised' => 'foo.bar',
                'sanitised' => 'foo.bar',
            ],
            [
                'unsanitised' => 'foo.bar .baz',
                'sanitised' => 'foo.bar%20.baz',
            ],
        ];
    }
}
