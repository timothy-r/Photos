<?php namespace Ace\Facades;

use Illuminate\Support\Facades\Facade;

class ImageView extends Facade
{
    protected static function getFacadeAccessor() { return 'photo_view'; }
}
