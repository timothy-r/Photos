<?php

class PhotoApplicationTest extends TestCase {

	/**
	 * Test listing photos works
	 * @return void
	 */
	public function testCanListPhotos()
	{
		$response = $this->get('/photos');
		$this->assertTrue($response->isOk());
        $this->assertViewHas('photos');
	}

	public function testCanCreatePhoto()
	{
		$crawler = $this->client->request('GET', '/photos/create');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testCanStorePhoto()
	{
		$crawler = $this->client->request('POST', '/photos');

		$this->assertTrue($this->client->getResponse()->isOk());
	}
}
