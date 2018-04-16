<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\IndexController;
class Module
{
    const VERSION = '3.0.3-dev';

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
