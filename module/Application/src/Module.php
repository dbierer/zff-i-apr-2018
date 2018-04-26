<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\MvcEvent;
use Application\Controller\IndexController;
use Application\Service\Listener;

class Module
{
    const VERSION = '3.0.3-dev';
	const ERROR_LOG = __DIR__ . '/../../../data/logs/error.log';
	
	public function init($mm)
	{
		$evm = $mm->getEventManager();
		$evm->attach('*', [$this, 'whatever']);
	}
	
	public function onBootstrap(MvcEvent $e)
	{
		$evm = $e->getApplication()->getEventManager();
		$sm  = $e->getApplication()->getServiceManager();
		// or: choose an event which occurs well before the target
		//$evm->attach(MvcEvent::EVENT_ROUTE, [$this, 'onDispatch'], -99);
		$listener = $sm->get(Service\Listener::class);
		$evm->attach(MvcEvent::EVENT_DISPATCH, [$listener, 'onDispatch'], 99);

		$shared = $evm->getSharedManager();
		$shared->attach('ID', 'whatever', [$this, 'whatever'], 99);
		// NOTE: this trigger doesn't pass the 'ID' filter
		//       we could add an identifier of "ID" to $evm and then it would work
		//$evm->addIdentifiers(['ID']);
		$evm->trigger('whatever', $this, ['x'=>'XXX','y'=>'YYY']);
	}
	public function whatever($e)
	{
		// have a look in 
		$message = date('Y-m-d H:i:s') 
				 . ':' . $e->getName() 
				 . ':' . get_class($e->getTarget()) 
				 . ':' . implode(',', array_keys($e->getParams()))
				 . PHP_EOL;
		error_log($message, 3, self::ERROR_LOG);
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
			'factories' => [
				Service\Listener::class => function ($container) {
					return new Listener($container);
				},
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
