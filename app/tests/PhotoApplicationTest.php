<?php

class PhotoApplicationTest extends TestCase {

	/**
	 * Test listing photos works
	 * @return void
	 */
	public function testCanListPhotos()
	{
		$crawler = $this->client->request('GET', '/');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

}
