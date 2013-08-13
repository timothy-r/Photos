<?php
use Ace\Photos\IImageStore;
use Ace\Photos\IImageFactory;
use Ace\Photos\ImageStore;
use Ace\Photos\PhotoView;

class PhotoController extends \BaseController
{
    /**
    * @var Ace\Photos\IImageFactory
    */
    protected $factory;

    /**
    * @param Ace\Photos\IImageStore $store
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
        
        /**
        * @todo move to view
        */
        $this->get_photo_data = function($image){
            return [
                'id' => $image->getId(),
                'name' => $image->getName(),
                'last_modified' => $image->getLastModified(),
                'hash' => $image->getHash(),
                'uri' => URL::action('PhotoController@show', [$image->getId()])
            ];
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
        $photos = ImageStore::all();

        // convert $photos to an array of data for presentation
        $data = array_map($this->get_photo_data, $photos);
        return $this->createResponse('photos', ['photos' => $data]);
    }

    /**
    * @todo move to a view clas
    * @todo use the Request class methods - no need for an AcceptParser class
    *
    * Get target Content-Type based on Accept header
    * eg. application/json, text/hml, application/xml
    * set reponse Content-Type and content body
    * also needs to set ETag and LastModified headers too
    */
    protected function createResponse($name, $data, array $headers = [])
    {
        $negotiator = App::make('\Negotiation\FormatNegotiator');
        $format = $negotiator->getBest(Request::header('Accept'), ['text/html', 'application/json']);
        if ($format->getValue() === 'text/html') { 
            return Response::make(View::make($name, $data), 200, $headers);
        } else if ($format->getValue() === 'application/json') { 
            return Response::json($data, 200, $headers);
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
        if ($photo) {
            $last_modified = new DateTime;
            $last_modified->setTimestamp($photo->getLastModified());
            $headers = ['ETag' => $photo->getHash(), 'Last-Modified' => http_date($last_modified)]; 

            // test the request ETag against the one for this Image
            // if they match return a NotModified status 304
            $request_etag = Request::header('If-None-Match');
            if ($request_etag === $photo->getHash()){
                return PhotoView::notModified($photo);
            }
            $data = call_user_func($this->get_photo_data, $photo);
            return $this->createResponse(
                'photo', 
                ['photo' => $data], 
                $headers 
            );
        } else {
            return PhotoView::notFound($id);
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
        $photo = ImageStore::get($id);
        if ($photo) {
            // test the request ETag against the one for this Image
            // if they don't match return a Precondition Failed (412) response
            $request_etag = Request::header('If-Match');
            if ($request_etag && ($request_etag !== $photo->getHash())){
                return PhotoView::preconditionFailed($photo);
            }

            $name = Input::get('name');
            $photo->setName($name);

            // store Image
            ImageStore::update($photo);

            // redirect to view Photo
            return Redirect::action('PhotoController@show', [$id]);
        } else {
            return PhotoView::notFound($id);
        }
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
        if ($photo) {
            // test the request ETag against the one for this Image
            // if they don't match return a Precondition Failed (412) response
            $request_etag = Request::header('If-Match');
            if ($request_etag && ($request_etag !== $photo->getHash())){
                return PhotoView::preconditionFailed($photo);
            }
            $result = ImageStore::remove($photo);
            if ($result) {
                return Redirect::action('PhotoController@index');
            } else {
                // show photo
                return Redirect::action('PhotoController@show', [$id]);
            }
        } else {
            return PhotoView::notFound($id);
        }
	}
}
