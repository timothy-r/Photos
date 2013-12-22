<?php
use Ace\Photos\Filter\ImageIfMatch;

class ImageIfMatchTest extends FilterTest
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

        $this->filter = new ImageIfMatch;
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
        
        $this->filter = new ImageIfMatch;
        $this->whenTheFilterIsRun();
        $this->thenTheFilterFailed(412);
    }
}
