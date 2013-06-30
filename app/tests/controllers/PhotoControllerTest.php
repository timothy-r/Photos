<?php

class PhotoApplicationTest extends TestCase {

	/**
	 * Test listing photos works
	 * @return void
	 */
	public function testCanListPhotos()
	{
		$crawler = $this->client->request('GET', '/photos');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testCanCreatePhoto()
	{
		$crawler = $this->client->request('GET', '/photos/create');

		$this->assertTrue($this->client->getResponse()->isOk());
	}
}
