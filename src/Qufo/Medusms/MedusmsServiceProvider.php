<?php namespace Qufo\Medusms;

use Illuminate\Support\ServiceProvider;

class MedusmsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('qufo/medusms');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['medusms'] = $this->app->share(function($app){
            $config = $app['config']->get('medusms::config');
            return new Medusms($config['sn'],$config['pwd'],$config['sign'],$config['ext'],$config['host']);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('medusms');
	}

}
