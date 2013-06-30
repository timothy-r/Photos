<?php

class FunctionsTest extends TestCase
{

    public function testLinkTo()
    {
        $actual = link_tag('dogs/1', 'Show dog');
        $expected = "<a href='http://:/dogs/1'>Show dog</a>";
        $this->assertSame($expected, $actual);
    }
}
