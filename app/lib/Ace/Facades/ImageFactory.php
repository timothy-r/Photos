<?php namespace Ace\Facades;

use Illuminate\Support\Facades\Facade;

class ImageFactory extends Facade
{
    protected static function getFacadeAccessor() { return 'image_factory'; }
}
