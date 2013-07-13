<?php


class ApplicationTest extends TestCase
{
    public function testCanSeeHomePage()
    {
		$crawler = $this->client->request('GET', '/');
		$this->assertTrue($this->client->getResponse()->isOk());
    }
}
