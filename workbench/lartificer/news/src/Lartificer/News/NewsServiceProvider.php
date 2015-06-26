<?php namespace Lartificer\News;

use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
        // Include the translations
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'news');

        // Include the views
        $this->loadViewsFrom(__DIR__ . '/../../views', 'news');

        // Include the routes
        include __DIR__ . '/../../routes.php';

        // Publish your migrations
        $this->publishes([
            __DIR__.'/../../database/migrations/' => database_path('/migrations')
        ], 'migrations');

        // Publish the JavaScript and CSS
        $this->publishes([
            __DIR__.'/Resources' => public_path('vendor/news'),
        ], 'public');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}
