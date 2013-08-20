<?php namespace Ace\Photos;

use Illuminate\Support\ServiceProvider;

/**
*/
class ImageViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ace\Photos\IImageView',
            'Ace\Photos\ImageView'
        );
    }
}
