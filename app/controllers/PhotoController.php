<?php
use Ace\Photos\IImageStore;
use Ace\Photos\Image;

class PhotoController extends \BaseController
{
    /**
    * @var Ace\Photos\IImageStore
    */
    protected $store;

    /**
    * @param Ace\Photos\IImageStore $store
    */
    public function __construct(IImageStore $store)
    {
        $this->store = $store;
        $this->beforeFilter(
            'photo-validate-store', 
            array('only' => array('store'))
        );
    }

	/**
	 * Display a listing of photos
	 * @todo base output Content-Type on the Request headers
     *
	 * @return Response
	 */
	public function index()
	{
        // obtain an array of Image objects to display
        $photos = $this->store->all();
        return $this->createResponse('photos', array('photos' => $photos));
    }

    /**
    * Get target Content-Type based on Accept header
    * eg. application/json, text/hml, application/xml
    * set reponse Content-Type from what it will be
    * generate response based on requested Content-Type
    */
    protected function createResponse($name, $data)
    {
        $types = explode(',', Request::header('Accept'));
        if (in_array('text/html', $types)) { 
            return View::make($name, $data);
        } else if (in_array('application/json', $types)) { 
            return Response::make(
                Response::json($data),
                200, 
                array('Content-Type' => 'application/json')
            );
        }
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

        // @todo use a factory
        // create an Image instance
        $image = new Image;
        // set its members
        $image->setName($name);

        // add Image to Store
        $this->store->add($image);
        // redirect to view all Photos
        return Redirect::action('PhotoController@index');
	}

	/**
	 * View the photo
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $photo = $this->store->get($id);
        // add validation here
        if ($photo) {
            return View::make('photo', array('photo' => $photo));
        } else {
            return Redirect::action('PhotoController@index')
                ->withInput()
                ->withErrors(array('Photo not found')
            );
        }
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
		//
	}

	/**
	 * Remove the specified photo
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
}
