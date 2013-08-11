<?php namespace Ace\Photos;

use Illuminate\Support\Facades\Facade;

class ImageStore extends Facade
{
    protected static function getFacadeAccessor() { return 'image_store'; }
}

