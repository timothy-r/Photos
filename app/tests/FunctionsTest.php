<?php

class FunctionsTest extends TestCase
{

    public function testLinkTo()
    {
        $actual = link_tag('/dogs/1', 'Show dog');
        $expected = '<a href="/dogs/1">Show dog</a>';
        $this->assertSame($expected, $actual);
    }

    /**
    * @dataProvider getHttpDateFixtures
    */
    public function testHttpDate($t, $expected)
    {
        $date = new DateTime();
        $date->setTimestamp($t);
        $http_date = http_date($date);
        $this->assertEquals($expected, $http_date);
    }

    public function getHttpDateFixtures()
    {
        return [
            [0, 'Thu, 01 Jan 1970 00:00:00 GMT'],    
            [1376150268, 'Sat, 10 Aug 2013 15:57:48 GMT']    
        ];

    }
}
