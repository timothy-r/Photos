<?php

use Ace\Photos\AssertTrait;
use Ace\Photos\MockTrait;

abstract class FilterTest extends TestCase
{
    use AssertTrait;

    use MockTrait;

    protected $result;

    protected $filter;

    protected $mock_entity_handler;

    protected function whenTheFilterIsRun()
    {
        $this->result = $this->filter->filter($this->mock_route, $this->request);
    }

    protected function thenTheFilterFailed($status)
    {
        $this->assertInstanceOf('Illuminate\Http\Response', $this->result);
        $this->assertSame($status, $this->result->getStatusCode());
    }

    protected function givenAMockEntityHandler($result)
    {
        // mock EntityHandler
        $this->mock_entity_handler = $this->mock('Ace\EntityHandler', ['matches']);
        $this->mock_entity_handler->expects($this->any())
            ->method('matches')
            ->will($this->returnValue($result));
    }

    protected function thenTheFilterPassed()
    {
        $this->assertNull($this->result);
    }
}
