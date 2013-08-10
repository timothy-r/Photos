<?php
namespace Ace\Photos;

use Illuminate\Support\ServiceProvider;

/**
* It's approriate to bind two services here as we always want them bound together
* Other MongoDb lib specific services should be bound here also
*
* Consider this to be a version of abstract factory
*
* Binds the MongoDbImageStore class to the IImageStore interface
* Binds the MongoDbImageFacotry class to the IImageFactory interface
*/
class MongoDbImageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ace\Photos\IImageStore',
            'Ace\Photos\MongoDbImageStore'
        );
        
        $this->app->bind(
            'Ace\Photos\IImageFactory',
            'Ace\Photos\MongoDbImageFactory'
        );
        
    }
}
