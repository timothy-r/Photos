<?php namespace Ace\Photos;

use Ace\Facades\ImageStore;
// @todo investigate the class name clash with Ace\Photos\ImageView
use Ace\Facades\ImageView as ImgView;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;

/**
* Validates that an image exists
* Returns a Response object on failure
*/
class ImageExistsFilter
{
    /**
    * @param Illuminate\Routing\Route $route
    * @param Illuminate\Http\Request $request
    *
    * @return mixed null|Illuminate\Http\Response
    */
    public function filter(Route $route, Request $request)
    {
        $id = $route->getParameter('photos');
        $image = ImageStore::get($id);
        
        if (null === $image) {
            return ImgView::notFound($id);
        }
    }
}
