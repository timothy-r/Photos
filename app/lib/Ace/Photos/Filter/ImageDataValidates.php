<?php namespace Ace\Photos\Filter;

// @todo investigate the class name clash with Ace\Photos\ImageView
use Ace\Facades\ImageView as ImgView;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

/**
* Validates that incoming data is valid to create/update an image
* Returns a Response object on failure, null on success
*/
class ImageDataValidates
{
    /**
    * @param Illuminate\Routing\Route $route
    * @param Illuminate\Http\Request $request
    *
    * @return mixed null|Illuminate\Http\Response
    */
    public function filter(Route $route, Request $request)
    {
        $rules = 
        [
            'title' => 'required',
            'file' => 'image|required'
        ];
        
        $validator = Validator::make($this->getInput(), $rules);

        if (!$validator->passes()) {
            // display / log $validator->messages() 
            return ImgView::badRequest();
        }
    }
    
    /**
    * Wraps call to Input::all() to make mocking easy
    */
    protected function getInput()
    {
        return Input::all();
    }
}
