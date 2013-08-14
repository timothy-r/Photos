<?php

use Ace\EntityHandler;

class EntityHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
    * Test that If-Match header is a match for the ETag parameter
    *
    * @dataProvider getMatchFixtures
    */
    public function testMatch($header, $etag)
    {
        $handler = new EntityHandler;
        $result = $handler->matches($header, $etag);
        $this->assertTrue($result, "Expected '$header' to match '$etag'");
    }

    public function getMatchFixtures()
    {
        return [
            ['4a190eff', '4a190eff'],
            ['*', '58be4a190eff']
        ];
    }
}
