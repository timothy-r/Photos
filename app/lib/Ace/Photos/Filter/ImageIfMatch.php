<?php namespace Ace\Photos\Filter;

use Ace\Facades\ImageStore;
// @todo investigate the class name clash with Ace\Photos\ImageView
use Ace\Facades\ImageView as ImgView;
use Ace\Facades\EntityHandler;

use Illuminate\Routing\Route;
use Illuminate\Http\Request;

/**
* Validates that an image's ETag against the request header If-Match 
* Depends on the image existing
* Returns a Response object on failure
*/
class ImageIfMatch
{
    /**
    * for If-Match header set : check that ETag matches and if not then return a preconditionFailed response
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
        $if_match = $request->headers->get('If-Match');

        // really ought not expose this filter to how an Image Etag is generated
        if ($if_match && ! EntityHandler::matches($if_match, $image->getHash())){
            return ImgView::preconditionFailed($image);
        }
        // returning nothing is success 
    }
}
