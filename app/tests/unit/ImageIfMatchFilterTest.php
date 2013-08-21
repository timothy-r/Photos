<?php
use Ace\Photos\ImageIfMatchFilter;

class ImageIfMatchFilterTest extends FilterTest
{
    public function testMatchingImageIsValid()
    {
        $id = 1;
        $this->givenAMockRoute($id);
        $this->givenAMockImageStore();
        $this->givenAMockImage();

        // mock the Request
        $this->filter = new ImageIfMatchFilter;
        $this->whenTheFilterIsRun();
        $this->thenTheFilterPassed();
    }

    public function testNoneMatchingImageIsNotValid()
    {
        $id = 1;
        $this->givenAMockRoute($id);
        $this->givenAMockImageStore();

        // mock the Request here
        $this->filter = new ImageIfMatchFilter;
        $this->whenTheFilterIsRun();
        $this->thenTheFilterFailed();
    }
}
