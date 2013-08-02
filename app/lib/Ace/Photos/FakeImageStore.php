<?php
namespace Ace\Photos;
use Ace\Photos\IImageStore;
use Ace\Photos\Image;

/**
* A fake repository for Images
*/
class FakeImageStore implements IImageStore
{
    
    public function add(Image $image)
    {
        return true;
    }

    public function all()
    {
        $all = array();
        $names = array('Grand Canyon', 'Eifle Tower', 'Sunset');
        $id = 1;
        foreach($names as $name) {
            $image = new Image;
            $image->setId($id++);
            $image->setName($name);
            $all []= $image;
        }
        return $all;
    }

    public function get($id)
    {
        $image = new Image;
        $image->setId($id);
        $image->setName('Special Effects');
        return $image;
    }
}
