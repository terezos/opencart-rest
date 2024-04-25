<?php
namespace Helpers;

use Illuminate\Database\Capsule\Manager as Capsule;

class Eloquent
{
    private $capsule = null;
    private $objectManager = null;
    private $config = null;
    private $hasAlreadyBooted = false;

    public function boot()
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver'    => 'mysql',
            'port'      => $_ENV['DB_PORT'],
            'host'      => $_ENV['DB_HOSTNAME'],
            'database'  => $_ENV['DB_DATABASE'],
            'username'  => $_ENV['DB_USERNAME'],
            'password'  => $_ENV['DB_PASSWORD'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => $_ENV['DB_PREFIX'],
        ]);

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();

    }

}
