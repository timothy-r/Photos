<?php
use Ace\AcceptParser;

class AcceptParserTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @dataProvider getHeaders
    */
    public function testIsAcceptable($type, $header)
    {
        $parser = new AcceptParser;
        $result = $parser->isAcceptable($type, $header);
        $this->assertTrue($result, "Expected '$type' to be acceptable from '$header'");
    }

    public function getHeaders()
    {
        return array(
            array('text/html', 'text/html, application/xml'),
            array('text/plain', 'text/html, application/xml, text/plain'),
            array('application/xml', 'text/html, application/xml'),
            array('application/json', 'application/json'),
            array('application/xml', 'application/json, application/xml'),
        );
    }
}
