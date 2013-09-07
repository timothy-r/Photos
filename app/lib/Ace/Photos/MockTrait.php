<?php namespace Ace\Photos;

use Illuminate\Http\Request;
use App;

trait MockTrait
{
    protected $mock_image;
    protected $mock_image_store;
    protected $mock_factory;
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

    protected function givenAMockImage($id = 1)
    {
        $this->mock_image = $this->getMock('Ace\Photos\Image', ['getId', 'getHash', 'getLastModified']);
        $this->mock_image->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($id));
        $this->mock_image->expects($this->any())
            ->method('getHash')
            ->will($this->returnValue('52063fab1e'));
        $this->mock_image->expects($this->any())
            ->method('getLastModified')
            ->will($this->returnValue(time()));
        if ($this->mock_image_store) {
            $this->mock_image_store->expects($this->any())
                ->method('get')
                ->will($this->returnValue($this->mock_image));
        }
    }

    protected function givenAMockImageStore(){
        $this->mock_image_store = $this->mock('Ace\Photos\IImageStore',
            ['all', 'add', 'get', 'remove', 'update']
        );
    }

    protected function givenARequest(){
        $this->request = new Request;
    }

    protected function givenAMockRequest(array $data){
        $keys = array_keys($data);
        $this->request = $this->getMock('Illuminate\Http\Request', ['only']);
        $this->request->expects($this->any())
            ->method('only')
            ->will($this->returnValue($data));
    }

    protected function givenAMockFactory()
    {
        $this->mock_factory = $this->mock(
            'Ace\Photos\IImageFactory',
            ['create']
        );
    }

    protected function mock($class, $methods)
    {
        $mock = $this->getMock($class, $methods);
        App::instance($class, $mock);
        return $mock;
    }
}
