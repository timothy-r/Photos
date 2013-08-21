<?php
use Ace\Photos\ImageIfMatchFilter;

class ImageIfMatchFilterTest extends FilterTest
{
    public function testMatchingImageIsValid()
    {
        $id = 1;
        $this->givenAMockRoute($id);
        $this->givenAMockImageStore();
        $this->givenARequest();

        // set up the request
        $this->request->headers->set('If-Match', 'abcdef');
        // mock EntityHandler

        $this->givenAMockImage();

        $this->filter = new ImageIfMatchFilter;
        $this->whenTheFilterIsRun();
        $this->thenTheFilterPassed();
    }

    public function testNoneMatchingImageIsNotValid()
    {
        $id = 1;
        $this->givenAMockRoute($id);
        $this->givenAMockImageStore();
        $this->givenARequest();

        // mock the Request here
        $this->filter = new ImageIfMatchFilter;
        $this->whenTheFilterIsRun();
        $this->thenTheFilterFailed();
    }
}
