<?php

namespace Elphas\Recommender;

use Illuminate\Support\ServiceProvider;

class RecommenderServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->setupConfig();
		$this->setupRoutes();
	}

	protected function setupConfig()
	{
		$source = realpath(__DIR__ . '/../config/recommender.php');

		$this->publishes([$source => config_path('recommender.php')]);

		$this->mergeConfigFrom($source, 'recommender');
	}

	protected function setupRoutes()
	{
		require __DIR__ .'/Routes/routes.php';
	}

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
		$this->app->singleton(Recommender::class, function ($app) {

			$config = $app['config'];

			return new Recommender($config);
		});

		$this->app->alias(Recommender::class, 'Recommender');


		//php artisan vendor:publish --provider="elphas\recommender\RecommenderServiceProvider"
    }


}
