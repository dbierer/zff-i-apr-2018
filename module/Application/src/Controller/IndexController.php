<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $whatever;
    public function __construct($whatever)
    {
	$this->whatever = $whatever;
    }
    public function indexAction()
    {
        return new ViewModel();
    }
    public function whateverAction()
    {
		$evm = $this->getEventManager();
		$evm->addIdentifiers(['ID']);
		// the following gets the MVC event manager:
		//$evm = $this->getEvent()->getApplication()->getEventManager();
		$evm->trigger('whatever', $this, ['a'=>'AAA','b'=>'BBB','c'=>'CCC']);
        return new ViewModel(['whatever' => $this->whatever]);
    }
    public function testAction()
    {
		$title = $this->params()->fromQuery('title', __METHOD__);
        return new ViewModel(['title' => $title, 'request' => $this->getRequest(), 'routeMatch' => $this->getEvent()->getRouteMatch()]);
    }
    public function shortCircuitAction()
    {
	$response = $this->getResponse();
	$response->setContent('<h1>Everything is under control.  Don\'t Panic.</h1>');
        return $response;
    }
    public function urlAction()
    {
        return new ViewModel(['url' => $this->url()->fromRoute('market', ['name' => 'whatever'])]);
    }
}
