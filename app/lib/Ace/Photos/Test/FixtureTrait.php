<?php namespace Ace\Photos\Test;

use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FixtureTrait
{
    /**
    * UploadedFile
    */
    protected $file;

    protected function givenAFile()
    {
        $file = __DIR__.'/../../../../tests/fixtures/tux.png';
        // UploadedFile extracts the mime-type from the file itself
        // the one passed to the constructor is available from getClientMimeType()
        $mime_type = 'image/png';
        $this->file = new UploadedFile($file, 'File', $mime_type);
    }
}
