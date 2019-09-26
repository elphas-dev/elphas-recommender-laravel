<?php

namespace Elphas\Recommender\Facades;

use Illuminate\Support\Facades\Facade;
//use Mollie\Laravel\Wrappers\MollieApiWrapper;

/**
 * (Facade) Class Recommender.
 *
 */
class Recommender extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'Recommender';
	}
}
