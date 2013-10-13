<?php namespace Ace\Photos;

use SplFileInfo;

interface IImageFactory
{
    /**
    * @param string $title
    * @param SplFileInfo $file the file on the local system
    * @return IImage
    */
    public function create($title, SplFileInfo $file);
}
