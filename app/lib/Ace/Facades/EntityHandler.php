<?php namespace Ace\Facades;

use Illuminate\Support\Facades\Facade;

class EntityHandler extends Facade
{
    protected static function getFacadeAccessor() { return 'entity_handler'; }
}
