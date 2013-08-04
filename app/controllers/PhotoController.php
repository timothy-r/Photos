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

        $this->get_photo_data = function($image){
            return array(
                'name' => $image->getName(),
                'uri' => ''
            );
        };
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
        // convert $photos to an array of data for presentation
        $data = array_map($this->get_photo_data, $photos);
        return $this->createResponse('photos', array('photos' => $data));
    }

    /**
    * @todo move to a view clas
    *
    * Get target Content-Type based on Accept header
    * eg. application/json, text/hml, application/xml
    * set reponse Content-Type and content body
    * also needs to set ETag and LastModified headers too
    */
    protected function createResponse($name, $data)
    {
        $parser = new Ace\AcceptParser(Request::header('Accept'));
        if ($parser->isAcceptable('text/html')) { 
            return View::make($name, $data);
        } else if ($parser->isAcceptable('application/json')) { 
            return Response::json($data);
        } else {
            // return Not Acceptable status 406
            return Response::make('', 406);
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

        // store Image
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
        if ($photo) {
            $data = call_user_func($this->get_photo_data, $photo);
            return $this->createResponse('photo', array('photo' => $data));
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
