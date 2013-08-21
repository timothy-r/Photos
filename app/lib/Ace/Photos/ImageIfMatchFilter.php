<?php namespace Ace\Photos;

use Ace\Facades\ImageStore;
// @todo investigate the class name clash with Ace\Photos\ImageView
use Ace\Facades\ImageView as ImgView;
use Illuminate\Routing\Route;

/**
* Validates that an image's ETag against the request header If-Match 
* Depends on the image existing
* Returns a Response object on failure
*/
class ImageIfMatchFilter
{
    /**
    * for If-Match header set : check that ETag matches and if not then return a preconditionFailed response
    * if not set then return null
    *
    * @param Illuminate\Routing\Route $route
    *
    * @return mixed null|Illuminate\Http\Response
    */
    public function filter(Route $route)
    {
        $id = $route->getParameter('photos');
        $image = ImageStore::get($id);
            
    }
}
