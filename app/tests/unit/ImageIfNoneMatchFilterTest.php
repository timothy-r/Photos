<?php
use Ace\Photos\Filter\ImageIfNoneMatch;

class ImageIfNoneMatchTest extends FilterTest
{
    public function testNoneMatchingImageIsValid()
    {
        $id = 1;
        $this->givenAMockRoute($id);
        $this->givenAMockImageStore();
        $this->givenARequest();
        $this->request->headers->set('If-None-Match', 'abcdef');
        $this->givenAMockEntityHandler(false);
        $this->givenAMockImage();

        $this->filter = new ImageIfNoneMatch;
        $this->whenTheFilterIsRun();
        $this->thenTheFilterPassed();
    }

    public function testMatchingImageIsNotValid()
    {
        $id = 1;
        $this->givenAMockRoute($id);
        $this->givenAMockImageStore();
        $this->givenARequest();
        $this->request->headers->set('If-None-Match', 'abcdef');
        $this->givenAMockEntityHandler(true);
        $this->givenAMockImage();
        
        $this->filter = new ImageIfNoneMatch;
        $this->whenTheFilterIsRun();
        $this->thenTheFilterFailed(304);
    }
}
