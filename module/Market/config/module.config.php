<?php
namespace Market;

use Zend\Router\Http\ {Literal, Segment, Method};
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
	  'routes' => [
		'home' => [
			'type' => Literal::class,
			'options' => [
				'route'    => '/',
				'defaults' => [
					'controller' => Controller\IndexController::class,
					'action'     => 'index',
				],
			],
		],
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
			'may_terminate' => TRUE,
			'child_routes' => [
				'index' => [
					'type' => Literal::class,
					'options' => [
						'route' => '/',
						'defaults' => [
						'controller' => Controller\IndexController::class,
						'action' => 'index',
						],
					],			
				],
				// TODO: add routes to capture "category" and "itemId"
				'view' => [
					'type' => Literal::class,
					'options' => [
						'route' => '/view',
						'defaults' => [
							'controller' => Controller\ViewController::class,
							'action' => 'index',
						],
					],			
					'may_terminate' => TRUE,
					'child_routes' => [
						'category' => [
							'type' => Segment::class,
							'options' => [
								'route' => '/category[/:category]',
								'defaults' => [
									'controller' => Controller\ViewController::class,
									'action' => 'index',
									'category' => 'free',
								],
								'constraints' => [
									'category' => '[a-zA-Z0-9_-]+',
								],
							],			
						],
						'item' => [
							'type' => Segment::class,
							'options' => [
								'route' => '/item[/:itemId]',
								'defaults' => [
									'controller' => Controller\ViewController::class,
									'action' => 'item',
								],
								'constraints' => [
									'itemId' => '[0-9]+',
								],
							],			
						],
					],
				],
				'post' => [
					'type' => Segment::class,
					'options' => [
						'route' => '/post[/]',
						'defaults' => [
						'controller' => Controller\PostController::class,
						'action' => 'index',
						],
					],			
				],
			],
	    ],
	  ],
    ],
    'service_manager' => [
		'factories' => [
			Form\PostForm::class => Form\Factory\PostFormFactory::class,
			Form\PostFilter::class => Form\Factory\PostFilterFactory::class,
		],
    ],
    'controllers' => [
	// NOTE: this syntax is more typical for ZF 2.4 applications
	//'invokables' => [
	//    'market-index-controller' => Controller\IndexController::class,
	//],
	// NOTE: this syntax is more typical for ZF 3.x applications
        'factories' => [
            Controller\IndexController::class => Controller\IndexControllerFactory::class,
            Controller\ViewController::class => Controller\ViewControllerFactory::class,
            Controller\PostController::class => Controller\PostControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../templates',
        ],
    ],
];

