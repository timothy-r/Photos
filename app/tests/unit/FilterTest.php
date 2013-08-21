<?php

use Ace\Photos\AssertTrait;
use Ace\Photos\MockTrait;

abstract class FilterTest extends TestCase
{
    use AssertTrait;

    use MockTrait;

    protected $result;

    protected $filter;

    protected function whenTheFilterIsRun()
    {
        $this->result = $this->filter->filter($this->mock_route);
    }

    protected function thenTheFilterFailed()
    {
        $this->assertInstanceOf('Illuminate\Http\Response', $this->result);
    }

    protected function thenTheFilterPassed()
    {
        $this->assertNull($this->result);
    }
}
