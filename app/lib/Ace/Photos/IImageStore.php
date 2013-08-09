<?php
namespace Ace\Photos;
use Ace\Photos\Image;

/**
* An interface to repositories for Images
*/
interface IImageStore
{
    public function add(Image $image);

    public function all();

    public function get($id);

    public function remove(Image $image);
}
