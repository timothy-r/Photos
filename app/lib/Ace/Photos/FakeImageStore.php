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
        foreach($names as $name) {
            $image = new Image;
            $image->setName($name);
            $all []= $image;
        }
        return $all;
    }
}
