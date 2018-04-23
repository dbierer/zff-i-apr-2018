<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\MvcEvent;
use Application\Controller\IndexController;
class Module
{
    const VERSION = '3.0.3-dev';

	public function onBootstrap(MvcEvent $e)
	{
		$evm = $e->getApplication()->getEventManager();
		$shared = $evm->getSharedManager();
		$shared->attach('ID', 'whatever', [$this, 'whatever'], 99);
		$evm->trigger('whatever', $this, ['x'=>'XXX','y'=>'YYY']);
	}
	public function whatever($e)
	{
		echo $e->getName() . ':' . get_class($e->getTarget()) . ':' . var_export(array_keys($e->getParams()), TRUE);
	}
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig()
    {
        return [
        'services' => [
	    'application-whatever' => [
		'file' => __FILE__,
		'namespaces' => [
		    'application-module.php' => __NAMESPACE__
		],
	    ],
	],
	];
    }
    public function getControllerConfig()
    {
	return [
            'factories' => [
                Controller\IndexController::class => function ($container)
    		{
		    return new IndexController($container->get('application-whatever'));
		},
            ],
	];
    }
}
