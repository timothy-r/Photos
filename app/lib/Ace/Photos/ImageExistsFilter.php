<?php namespace Ace\Photos;

use Illuminate\Routing\Route;

/**
* Validates that an image exists
*/
class ImageExistsFilter
{
    /**
    * @param Route $route
    */
    public function filter(Route $route)
    {
        $id = $route->getParameter('photos');
    }
}
