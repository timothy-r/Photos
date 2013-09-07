<?php

use Ace\Photos\ImageDataValidatesFilter;

class ImageDataValidatesFilterTest extends FilterTest
{
    /**
    * @dataProvider getValidImageData
    */
    public function testValidImageDataIsAccepted($data)
    {
        $id = null; 
        $this->givenAMockRoute($id);
        $this->givenAMockRequest($data);

        $this->filter = new ImageDataValidatesFilter;
        $this->whenTheFilterIsRun();
        $this->thenTheFilterPassed();
    }

    public function getValidImageData()
    {
        return [
            [['name' => 'The view from the very top of Mont Blanc']]
        ];
    }

    /**
    * @dataProvider getInvalidImageData
    */
    public function testInvalidImageDataIsRejected($data)
    {
        $id = null; 
        $this->givenAMockRoute($id);
        $this->givenAMockRequest($data);

        $this->filter = new ImageDataValidatesFilter;
        $this->whenTheFilterIsRun();
        $this->thenTheFilterFailed(302, 'Illuminate\Http\RedirectResponse');
    }

    public function getInvalidImageData()
    {
        return [
            [['name' => '']],
            [['data' => 'abcd']],
            [[]]
        ];
    }

}
