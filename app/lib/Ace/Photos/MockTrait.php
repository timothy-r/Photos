<?php namespace Ace\Photos;

use Illuminate\Http\Request;

trait MockTrait
{
    protected $mock_image;
    protected $mock_image_store;
    protected $mock_route;
    protected $request;

    protected function givenAMockRoute($id)
    {
        $this->mock_route = $this->getMock('Illuminate\Routing\Route', ['getParameter'], [], '', false);
        $this->mock_route->expects($this->any())
            ->method('getParameter')
            ->with('photos')
            ->will($this->returnValue($id));
    }

    protected function givenAMockImage()
    {
        $this->mock_image = $this->getMock('Ace\Photos\Image', ['getHash']);
        $this->mock_image_store->expects($this->any())
            ->method('get')
            ->will($this->returnValue($this->mock_image));
    }

    protected function givenAMockImageStore(){
        $this->mock_image_store = $this->mock('Ace\Photos\IImageStore',
            ['all', 'add', 'get', 'remove', 'update']
        );
    }

    protected function givenARequest(){
        $this->request = new Request;
    }
}
