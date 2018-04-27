<?php
namespace Model;

return [
	'service_manager' => [
		'factories' => [
			Table\Listings::class => Table\ListingsFactory::class,
		],
	],
];
