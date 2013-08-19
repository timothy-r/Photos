<?php
use Ace\Photos\Image;
use Ace\Facades\ImageStore;
use Ace\Facades\ImageView;

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});


Route::filter('image-validate-store', function()
{
    $rules = array(
        'name' => 'required'
    );
    // @todo use array keys from $rules as params to only
    $validator = Validator::make(Input::only('name'), $rules);

    if (!$validator->passes()) {
        // redirect depends on caller / output type?
        // @todo put this redirect in a PhotoView method and call from here
        return Redirect::action('PhotoController@create')
            ->withInput()
            ->withErrors($validator->messages()
        );
    }
});

/**
* Add a filter to validate Images exist
* return a 404 if they don't
*/

Route::filter('image-exists', 'Ace\Photos\ImageExistsFilter');

/*
Route::filter('image-exists', function($route)
{
    $id = $route->getParameter('photos');
    $image = ImageStore::get($id);

    if (!$image) {
        return ImageView::notFound($id);
    }
});
*/


/**
* add filters to handle ETags in requests
* they need to be able to:
* a) get the Image object from the request
* b) generate an ETag for it
* c) get the request headers (from Request facade)
* d) call PhotoView methods (easy as it's a facade)
*/
Route::filter('image-validate-etag', function($route)
{
    $id = $route->getParameter('photos');

    $image = ImageStore::get($id);

    // get If-Match and If-None-Match headers from request
    // for If-Match check that etag matches and if not then return a prconditionFailed response
    // for If-None-Match check that etag matches and if it does then return notModified
    $request_etag = Request::header('If-None-Match');

});
