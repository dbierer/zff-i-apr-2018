<?php
namespace Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class Module
{
	public function getConfig()
	{
		return include __DIR__ . '/../config/module.config.php';
	}
    public function getServiceConfig()
    {
		return [
			'factories' => [
				'model-primary-adapter' => function ($container) {
					return new Adapter($container->get('local-db-config'));
				},
			],
		];
    }
}

