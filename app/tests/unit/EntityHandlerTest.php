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

    public function testNonMatchingETagIsDetected()
    {
        $handler = new EntityHandler;
        $header = '8b14fec5';
        $etag = 'a093be2';
        $result = $handler->matches($header, $etag);
        $this->assertFalse($result, "Didn't expected '$header' to match '$etag'");
    }
}
