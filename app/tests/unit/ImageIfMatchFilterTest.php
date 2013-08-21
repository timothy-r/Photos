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
        $this->request->headers->set('If-Match', 'abcdef');
        $this->givenAMockEntityHandler(true);
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
        $this->request->headers->set('If-Match', 'abcdef');
        $this->givenAMockEntityHandler(false);
        $this->givenAMockImage();
        
        $this->filter = new ImageIfMatchFilter;
        $this->whenTheFilterIsRun();
        $this->thenTheFilterFailed(412);
    }
}
