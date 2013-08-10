<?php
namespace Ace\Photos;

use Illuminate\Support\ServiceProvider;

/**
* Binds the MongoDbImageStore class to the IImageStore interface
*/
class MongoDbImageStoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ace\Photos\IImageStore',
            'Ace\Photos\MongoDbImageStore'
        );
    }
}
