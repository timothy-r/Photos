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
            'photo-validate', 
            array('only' => array('store', 'update'))
        );
    }

	/**
	 * Display a listing of photos
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
        // validate
        if (!$this->validatePhotoData(array('name' => $name))) {
            // send request back ?
            return Redirect::action('PhotoController@create');
        }

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
		//
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

    /**
    * test if data is valid
    * @return boolean
    */
    protected function validatePhotoData(array $data)
    {
        $validator = Validator::make(
            array('name' => $data['name']),
            array('name' => 'required')
        );
        
        return $validator->passes();
    }
}
