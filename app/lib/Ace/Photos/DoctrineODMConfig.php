<?php namespace Ace\Photos;

use Ace\Photos\IDoctrineODMConfig;
use Doctrine\Common\ClassLoader,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

class DoctrineODMConfig implements IDoctrineODMConfig
{
    /**
    * @todo use real directories for proxy dir, hydrator dir, documents etc
    */
    public function getDocumentManager()
    {
        //$this->init();
         $config = new Configuration();
         $config->setProxyDir(__DIR__ . '/cache');
         $config->setProxyNamespace('Proxies');

         $config->setHydratorDir(__DIR__ . '/cache');
         $config->setHydratorNamespace('Hydrators');

         $reader = new AnnotationReader();

         $driver = new AnnotationDriver($reader, __DIR__.'/Documents');
         $driver->registerAnnotationClasses();

         //$reader->setDefaultAnnotationNamespace('Doctrine\ODM\MongoDB\Mapping\\');
         $config->setMetadataDriverImpl($driver);
            
         //$doc = new \Doctrine\ODM\MongoDB\Mapping\Annotations\Document([]);

         return DocumentManager::create(new Connection(), $config);
    }

    /**
    * composer should handle all this
    */
    public function init()
    {
         // ODM Classes
         $classLoader = new ClassLoader('Doctrine\ODM\MongoDB', 'lib/vendor/doctrine-mongodb-odm/lib');
         $classLoader->register();

         // Common Classes
         $classLoader = new ClassLoader('Doctrine\Common', 'lib/vendor/doctrine-mongodb-odm/lib/vendor/doctrine-common/lib');
         $classLoader->register();

         // MongoDB Classes
         $classLoader = new ClassLoader('Doctrine\MongoDB', 'lib/vendor/doctrine-mongodb-odm/lib/vendor/doctrine-mongodb/lib');
         $classLoader->register();

         // Document classes
         $classLoader = new ClassLoader('Documents', __DIR__);
         $classLoader->register();
    }
}
