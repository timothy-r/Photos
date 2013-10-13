<?php namespace Ace\Photos;

// @todo investigate the class name clash with Ace\Photos\ImageView
use Ace\Facades\ImageView as ImgView;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

/**
* Validates that incoming data is valid to create/update an image
* Returns a Response object on failure
*/
class ImageDataValidatesFilter
{
    /**
    * @param Illuminate\Routing\Route $route
    * @param Illuminate\Http\Request $request
    *
    * @return mixed null|Illuminate\Http\Response
    */
    public function filter(Route $route, Request $request)
    {
        $rules = [
            'title' => 'required'
        ];

        $validator = Validator::make($request->only(array_keys($rules)), $rules);

        if (!$validator->passes()) {
            return ImgView::badRequest();
        }
    }
}
