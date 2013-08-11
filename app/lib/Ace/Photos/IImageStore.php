<?php
namespace Ace\Photos;
use Ace\Photos\IImage;

/**
* An interface to repositories for Images
*/
interface IImageStore
{
    public function add(IImage $image);

    public function update(IImage $image);

    public function all();

    public function get($id);

    public function remove(IImage $image);
}
