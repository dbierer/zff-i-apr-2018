<?php
namespace Application\Service;

use Zend\ServiceManager\ServiceManager;
class Listener
{
	protected $serviceManager;
	public function __construct(ServiceManager $sm)
	{
		$this->serviceManager = $sm;
	}
	public function onDispatch($e)
	{
		$layoutViewModel = $e->getViewModel();
		$layoutViewModel->setVariable('categories', $this->serviceManager->get('categories'));
	}
}
