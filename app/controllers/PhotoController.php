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
            'image-validate', 
            ['only' => ['store', 'update']]
        );

        $this->beforeFilter(
            'image-exists', 
            ['only' => ['show', 'update', 'destroy']]
        );
        
        $this->beforeFilter(
            'image-matches', 
            ['only' => ['update', 'destroy']]
        );

        $this->beforeFilter(
            'image-does-not-match', 
            ['only' => ['show']]
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
        $images = ImageStore::all();
        
        // call the view to return a reponse based on Accept header in request
        // var_dump($images);

        return ImageView::makeManyAcceptable($images);
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
        $title = Input::get('title');
        
        $file = Input::file('file');

        // pass uploaded file path to factory here 
        // create an Image instance
        $image = ImageFactory::create($title, $file);
        
        // store Image
        $result = ImageStore::add($image);
        if ($result) {
            // redirect to view Photo
            return Redirect::action('PhotoController@show', [$image->getId()]);
        }

        // re-show create form & errors 
        return Redirect::action('PhotoController@create', []);
	}

	/**
	 * View the photo
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $image = ImageStore::get($id);

        return ImageView::makeAcceptable($image);
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

        $title = Input::get('title');

        // update the Image
        $image->setTitle($title);

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

        // delete failed - show image - show an error message
        return Redirect::action('PhotoController@show', [$id]);
	}
}
