<?php
use Ace\Photos\IImageFactory;

use Ace\Facades\ImageStore;
use Ace\Photos\PhotoView;
use Ace\Facades\EntityHandler;

class PhotoController extends \BaseController
{
    /**
    * @var Ace\Photos\IImageFactory
    */
    protected $factory;

    /**
    * @param Ace\Photos\IImageFactory $factory
    */
    public function __construct(IImageFactory $factory)
    {
        $this->factory = $factory;

        $this->beforeFilter('csrf',
            ['only' => 'store update']
        );

        $this->beforeFilter(
            'photo-validate-store', 
            ['only' => ['store']]
        );
        
        /*
        $this->beforeFilter(
            'photo-validate-etag', 
            ['only' => ['show']]
        );
        */
        
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
        return PhotoView::makeManyAcceptable($photos);
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
        $image = $this->factory->create($name);

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

        if (!$photo) {
            return PhotoView::notFound($id);
        }

        // test the request ETag against the one for this Image
        // if they match return a NotModified status 304
        if (EntityHandler::matches(Request::header('If-None-Match'), $photo->getHash())){
            return PhotoView::notModified($photo);
        }

        return PhotoView::makeAcceptable($photo);
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
        $photo = ImageStore::get($id);
        if (!$photo) {
            return PhotoView::notFound($id);
        }

        // test the request ETag against the one for this Image
        // if they don't match return a Precondition Failed (412) response
        $request_etag = Request::header('If-Match');
        if ($request_etag && ! EntityHandler::matches($request_etag, $photo->getHash())){
            return PhotoView::preconditionFailed($photo);
        }

        $name = Input::get('name');
        $photo->setName($name);

        // store Image
        ImageStore::update($photo);

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
        $photo = ImageStore::get($id);
        if (!$photo) {
            return PhotoView::notFound($id);
        }

        // test the request ETag against the one for this Image
        // if they don't match return a Precondition Failed (412) response
        $request_etag = Request::header('If-Match');
        if ($request_etag && ! EntityHandler::matches($request_etag, $photo->getHash())){
            return PhotoView::preconditionFailed($photo);
        }

        $result = ImageStore::remove($photo);
        if ($result) {
            return Redirect::action('PhotoController@index');
        } 

        // delete failed - show photo
        return Redirect::action('PhotoController@show', [$id]);
	}
}
