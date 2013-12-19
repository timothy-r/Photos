<?php

use Ace\Photos\Filter\ImageDataValidates;

/**
* @todo mock the Validator class
*/
class ImageDataValidatesTest extends FilterTest
{
    /**
    * @dataProvider getValidImageData
    */
    public function testValidImageDataIsAccepted($data)
    {
        $id = null; 
        $this->givenAMockRoute($id);
        $this->givenAMockRequest($data);

        $this->filter = new ImageDataValidates;
        $this->whenTheFilterIsRun();
        $this->thenTheFilterPassed();
    }

    public function getValidImageData()
    {
        return [
            [['title' => 'The view from the very top of Mont Blanc', 'file' => 'image.png']]
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

        $this->filter = new ImageDataValidates;
        $this->whenTheFilterIsRun();
        $this->thenTheFilterFailed(400);
    }

    public function getInvalidImageData()
    {
        return [
            [['title' => '', 'file' => 'photo.gif']],
            [['file' => '', 'title' => 'A photo']],
            [['data' => 'abcd']],
            [[]]
        ];
    }
}
