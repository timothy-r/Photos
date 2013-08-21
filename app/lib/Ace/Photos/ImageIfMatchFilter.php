<?php namespace Ace\Photos;

use Ace\Facades\ImageStore;
// @todo investigate the class name clash with Ace\Photos\ImageView
use Ace\Facades\ImageView as ImgView;
use Illuminate\Routing\Route;

/**
* Validates that an image's ETag against the request headers If-Match and If-None-Match
* Maybe split this into 2 filter? one per request header
* Depends on the image existing
* Returns a Response object on failure
*/
class ImageETagsFilter
{
    /**
    * for If-Match header set : check that ETag matches and if not then return a preconditionFailed response
    * for If-None-Match header set : check that ETag matches and if it does then return notModified
    * if neither header is set then return null
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
