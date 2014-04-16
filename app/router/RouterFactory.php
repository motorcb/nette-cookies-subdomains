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
	public function createRouter()
	{
		$router = new RouteList();
		//$router[] = new Route('<presenter>/<action>[/<id>]', 'Www:Homepage:default');
		//$router[] = new Route('<module=Www>.mojedomena.local/<presenter>/<action>[/<id>]', 'Homepage:default');
                
                $router[] = new Route( '//www.mojedomena.local/<presenter>/<action>[/<id>]', array(
                    'module' => 'Www',
                    'presenter' => 'Homepage',
                    'action' => 'default',
                ) );
                
                $router[] = new Route( '//fotbal.mojedomena.local/<presenter>/<action>[/<id>]', array(
                    'module' => 'Fotbal',
                    'presenter' => 'Homepage',
                    'action' => 'default',
                ) );
                
                $router[] = new Route( '//hokej.mojedomena.local/<presenter>/<action>[/<id>]', array(
                    'module' => 'Hokej',
                    'presenter' => 'Homepage',
                    'action' => 'default',
                ) );                

		return $router;
	}

}
