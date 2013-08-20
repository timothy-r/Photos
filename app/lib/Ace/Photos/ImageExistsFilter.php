<?php namespace Ace\Photos;

use Ace\Facades\ImageStore;
// @todo investigate the class name clash with Ace\Photos\ImageView
use Ace\Facades\ImageView as ImgView;
use Illuminate\Routing\Route;

/**
* Validates that an image exists
* Returns a Response object on failure
*/
class ImageExistsFilter
{
    /**
    * @param Illuminate\Routing\Route $route
    */
    public function filter(Route $route)
    {
        $id = $route->getParameter('photos');
        $image = ImageStore::get($id);
        
        #var_dump($image);
        if (null === $image) {
            return ImgView::notFound($id);
        }
    }
}
