<?php

use Ace\Photos\ImageExistsFilter;

class ImageExistsFilterTest extends FilterTest
{

    public function testExistingImageIsValid()
    {
        $id = 1;
        $this->givenAMockRoute($id);
        $this->givenAMockImageStore();
        $this->givenARequest();
        $this->givenAMockImage();

        $this->filter = new ImageExistsFilter;
        $this->whenTheFilterIsRun();
        $this->thenTheFilterPassed();
    }

    public function testMissingImageIsNotValid()
    {
        $id = 1;
        $this->givenAMockRoute($id);
        $this->givenAMockImageStore();
        $this->givenARequest();

        $this->filter = new ImageExistsFilter;
        $this->whenTheFilterIsRun();
        $this->thenTheFilterFailed(404);
    }
}
