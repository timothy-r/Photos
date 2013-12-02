<?php namespace Ace\Photos;

use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FixtureTrait
{
    protected $file;

    protected function givenAFile($mime_type = 'image/png')
    {
        $file = __DIR__.'/../../../tests/fixtures/tux.png';
        $this->file = new UploadedFile($file, 'File', $mime_type);
    }
}
