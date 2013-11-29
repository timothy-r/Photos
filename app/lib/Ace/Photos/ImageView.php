<?php namespace Ace\Photos;

use Ace\Photos\IImage;
use Ace\Photos\IImageView;

use Request;
use Response;
use DateTime;
use View;
use URL;
use App;

/**
 * Class to handle generating and returning responses
 *
 * @todo handle errors differently depending on Accept header
 * if text/html then redirect client, otherwise just return reponses
*/
class ImageView implements IImageView
{
    protected $get_photo_data;

    public function __construct()
    {
        $this->get_photo_data = function(IImage $image){
            return [
                'title' => $image->getTitle(),
                'last_modified' => $image->getLastModified(),
                'uri' => URL::action('PhotoController@show', [$image->getId()])
            ];
        };
    }

    public function makeAcceptable(IImage $image)
    {
        $data = call_user_func($this->get_photo_data, $image);
        $headers = $this->headers($image);
        return $this->getResponse('photo', ['photo' => $data], $headers);
    }

    public function makeManyAcceptable(array $images)
    {
        $data = array_map($this->get_photo_data, $images);
        return $this->getResponse('photos', ['photos' => $data], []);
    }

    /**
    * @todo add support for a reason for the 400 error
    */
    public function badRequest()
    {
        return Response::make('', 400);
    }

    /**
    * @todo make this more extensible?
    * it needs to deal with many more MimeTypes
    */
    protected function getResponse($name, $data, $headers)
    {
        // get best response format
        $type = $this->getAcceptableContentType();

        if ($type === 'text/html') {
            $headers['Content-Type'] = $type;
            $contents = View::make($name, $data);
            $response = Response::make($contents, 200, $headers);
            $response->header('Content-Length', strlen($contents));
            return $response;
        }

        if ($type === 'application/json') {
            $headers['Content-Type'] = $type;
            $contents = json_encode($data);
            $response = Response::make($contents, 200, $headers);
            $response->header('Content-Length', strlen($contents));
            return $response;
        }
        
        // return NotAcceptable status
        return $this->notAcceptable();
    }

    protected function getAcceptableContentType()
    {
        $negotiator = App::make('\Negotiation\FormatNegotiator');
        $format = $negotiator->getBest(Request::header('Accept'), ['text/html', 'application/json']);
        if ($format) {
            return $format->getValue(); 
        }
        return '';
    }

    public function notFound($id)
    {
        return Response::make('', 404);
    }
    
    public function notModified(IImage $image)
    {
        $response = Response::make('', 304, $this->headers($image));
        $response->setNotModified();
        return $response;
    }

    public function preconditionFailed(IImage $image)
    {
        return Response::make('', 412, $this->headers($image));
    }
    
    public function notAcceptable()
    {
        return Response::make('', 406);
    }

    protected function headers(IImage $image)
    {
        $headers = [];
        $headers['ETag'] = $image->getHash();
        $last_modified = new DateTime('GMT');
        $last_modified->setTimestamp($image->getLastModified());
        $headers['Last-Modified'] = http_date($last_modified);
        return $headers;
    }
}
