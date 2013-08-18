<?php namespace Ace\Photos;

use Illuminate\Support\ServiceProvider;

/**
*/
class ImageFactoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ace\Photos\IImageFactory',
            'Ace\Photos\MongoDbImageFactory'
        );
    }
}
