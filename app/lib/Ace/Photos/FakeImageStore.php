<?php namespace Ace\Photos;

use Ace\Photos\IImageStore;
use Ace\Photos\IImage;
use Ace\Photos\Image;

/**
* A fake repository for Images
*/
class FakeImageStore implements IImageStore
{
    
    public function add(IImage $image)
    {
        return true;
    }

    public function all()
    {
        return $this->createImages();
    }

    public function get($id)
    {
        if (0 == $id){
            return null;
        }

        foreach($this->createImages() as $image){
            if ($image->getId() == $id){
                return $image;
            }
        }

        // create a new Image
        $image = new Image;
        $image->setId($id);
        $image->setName('Special Effects');
        return $image;
    }

    public function remove(IImage $image)
    {

    }

    protected function createImages()
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
}
