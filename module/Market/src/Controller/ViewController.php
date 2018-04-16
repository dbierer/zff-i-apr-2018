<?php
namespace Market\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class ViewController extends AbstractActionController
{
    public function indexAction()
    {
	$category = $this->params()->fromRoute('category', FALSE);
	if (!$category) {
	    $this->flashMessenger()->addMessage('No Category Found');
	    return $this->redirect()->toRoute('market');
	}
	return new ViewModel(['category' => $category]);
    }
}

