<?php namespace Ace\Photos\Doctrine\ODM;

use Illuminate\Support\ServiceProvider;

/**
* It's approriate to bind multiple services here as we always want them bound together
*
* Consider this to be a version of abstract factory
*
* Binds the Doctrine\ODMConfig to the Doctrine\IODMConfig interface
* Binds the Doctrine\ODM\ImageStore class to the IImageStore interface
* Binds the Doctrine\ODM\ImageFactory class to the IImageFactory interface
*/
class ImageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ace\Photos\Doctrine\IODMConfig',
            'Ace\Photos\Doctrine\ODMConfig'
        );

        $this->app->bind(
            'Ace\Photos\IImageStore',
            'Ace\Photos\Doctrine\ODM\ImageStore'
        );
        
        $this->app->bind(
            'Ace\Photos\IImageFactory',
            'Ace\Photos\Doctrine\ODM\ImageFactory'
        );
    }
}
