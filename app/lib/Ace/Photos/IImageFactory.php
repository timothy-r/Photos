<?php namespace Ace\Photos;

interface IImageFactory
{
    /**
    * @param string $name
    * @return IImage
    */
    public function create($name, $filename);
}
