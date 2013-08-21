<?php

use Ace\Photos\IImageFactory;
use Ace\Facades\ImageStore;
use Ace\Facades\ImageFactory;
use Ace\Facades\ImageView;
use Ace\Facades\EntityHandler;

class PhotoController extends \BaseController
{
    public function __construct()
    {
        $this->beforeFilter('csrf',
            ['only' => 'store update']
        );

        $this->beforeFilter(
            'image-validate-store', 
            ['only' => ['store']]
        );

        $this->beforeFilter(
            'image-exists', 
            ['only' => ['show', 'update', 'destroy']]
        );
        
        $this->beforeFilter(
            'image-matches', 
            ['only' => ['update', 'destroy']]
        );
    }

	/**
	 * Display a listing of photos
     *
	 * @return Response
	 */
	public function index()
	{
        // obtain an array of Image objects to display
        $photos = ImageStore::all();
        
        // call the view to return a reponse based on Accept header in request
        return ImageView::makeManyAcceptable($photos);
    }

	/**
	 * Show the form for creating a new photo
	 * not needed if a backbone app presents the ui
     *
	 * @return Response
	 */
	public function create()
	{
        return View::make('photos-create');
	}

	/**
	 * Store a newly created photo in storage
	 *
	 * @return Response
	 */
	public function store()
	{
		// get the input data
        $name = Input::get('name');

        // create an Image instance
        $image = ImageFactory::create($name);

        // store Image
        ImageStore::add($image);

        // redirect to view Photo
        return Redirect::action('PhotoController@show', [$image->getId()]);
	}

	/**
	 * View the photo
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $photo = ImageStore::get($id);

        // test the request ETag against the one for this Image
        // if they match return a NotModified status 304
        if (EntityHandler::matches(Request::header('If-None-Match'), $photo->getHash())){
            return ImageView::notModified($photo);
        }

        return ImageView::makeAcceptable($photo);
	}

	/**
	 * Show the form for editing the photo
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the photo 
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $image = ImageStore::get($id);

        $name = Input::get('name');

        // update the Image
        $image->setName($name);

        // store Image
        ImageStore::update($image);

        // redirect to view Photo
        return Redirect::action('PhotoController@show', [$id]);
	}

	/**
	 * Remove the specified photo
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $image = ImageStore::get($id);

        if (ImageStore::remove($image)) {
            return Redirect::action('PhotoController@index');
        } 

        // delete failed - show image
        return Redirect::action('PhotoController@show', [$id]);
	}
}
