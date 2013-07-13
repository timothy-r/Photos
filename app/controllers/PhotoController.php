<?php
use Ace\Photos\IImageStore;

class PhotoController extends \BaseController
{
    /**
    * @var Ace\Photos\IImageStore
    */
    protected $store;

    /**
    * @param IImageStore $store
    */
    public function __construct(IImageStore $store)
    {
        $this->store = $store;
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
		//
        return 'a web form';
	}

	/**
	 * Store a newly created photo in storage
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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

}
