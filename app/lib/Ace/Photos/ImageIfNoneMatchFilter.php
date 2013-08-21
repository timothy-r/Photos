<?php namespace Ace\Photos;

use Ace\Facades\ImageStore;
// @todo investigate the class name clash with Ace\Photos\ImageView
use Ace\Facades\ImageView as ImgView;
use Ace\Facades\EntityHandler;

use Illuminate\Routing\Route;
use Illuminate\Http\Request;

/**
* Validates that an image's ETag against the request header If-None-Match 
* Depends on the image existing
* Returns a Response object on failure
*/
class ImageIfNoneMatchFilter
{
    /**
    * for If-None-Match header set : check that ETag does not matches and if it does then return a not modified response
    * if not set then return null
    *
    * @param Illuminate\Routing\Route $route
    * @param Illuminate\Http\Request $request
    * @return mixed null|Illuminate\Http\Response
    */
    public function filter(Route $route, Request $request)
    {
        $id = $route->getParameter('photos');
        $image = ImageStore::get($id);
        $if_none_match = $request->headers->get('If-None-Match');

        // really ought not expose this filter to how an Image Etag is generated
        if ($if_none_match && EntityHandler::matches($if_none_match, $image->getHash())){
            return ImgView::notModified($image);
        }
        // returning nothing is success 
    }
}
