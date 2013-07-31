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
        // inject a photos store into this controller
        $photos = $this->store->all();
        return View::make('photos', array('photos' => $photos));
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
	 * Display the specified photo
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $photo = $this->store->get($id);
        // add validation here ?
        return View::make('photo', array('photo' => $photo));
	}

	/**
	 * Show the form for editing the specified photo
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified photo in storage
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified photo from storage
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
}
