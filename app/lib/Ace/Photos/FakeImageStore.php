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
        return $this->createImages();
    }

    public function get($id)
    {
        $all = $this->createImages();
        foreach($all as $image){
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
