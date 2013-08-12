<?php namespace Ace\Photos;

use Illuminate\Support\Facades\Facade;

class PhotoView extends Facade
{
    protected static function getFacadeAccessor() { return 'photo_view'; }
}
