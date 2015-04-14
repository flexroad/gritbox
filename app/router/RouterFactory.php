<?php

namespace App;

use Nette,
	Nette\Application\Routers\RouteList,
	Nette\Application\Routers\Route,
	Nette\Application\Routers\SimpleRouter;


/**
 * Router factory.
 */
class RouterFactory
{

	/**
	 * @return \Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList();
		$router[] = new Route('admin/<presenter>/<action>[/<id>]', [
			'module' => 'Admin',
			'presenter' => 'Homepage',
			'action' => 'default',
		]);
		$router[] = new Route('<presenter>/<action>[/<id>]', [
			'module' => 'Front',
			'presenter' => 'Homepage',
			'action' => 'default',
		]);
		return $router;
	}

}
