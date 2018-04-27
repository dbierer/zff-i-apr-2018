<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                        'module'     => __NAMESPACE__,
                        'whatever'   => 'XYZ',
                    ],
                ],
            ],
        ],
    ],
//    'controllers' => [
//        'factories' => [
//            Controller\IndexController::class => InvokableFactory::class,
//        ],
//    ],
    'service_manager' => [
        'services' => [
			'application-whatever' => [
				'file' => __FILE__,
				'namespaces' => [
					'application-module-config' => __NAMESPACE__
				],
			],
		],
    ],
    'view_helpers' => [
		'factories' => [
			Helper\LeftLinks::class => InvokableFactory::class,
		],
		'aliases' => [
			'leftLinks' => Helper\LeftLinks::class,
		],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
