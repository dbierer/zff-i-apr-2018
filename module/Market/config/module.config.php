<?php
namespace Market;

use Zend\Router\Http\ {Literal, Segment};
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
	'routes' => [
	    'market' => [
		'type' => Literal::class,
		'options' => [
		    'route' => '/market',
		    'defaults' => [
			// NOTE: typical for ZF 2.4
			//'controller' => 'market-index-controller',
			'controller' => Controller\IndexController::class,
			'action' => 'index',
		    ],
		],
	    ],
	],
    ],
    'controllers' => [
	// NOTE: this syntax is more typical for ZF 2.4 applications
	//'invokables' => [
	//    'market-index-controller' => Controller\IndexController::class,
	//],
	// NOTE: this syntax is more typical for ZF 3.x applications
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];

