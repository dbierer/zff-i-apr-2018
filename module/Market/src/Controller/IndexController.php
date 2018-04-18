<?php
namespace Market\Controller;

use Market\Traits\CategoryTrait;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    use CategoryTrait;    
    public function indexAction()
    {
	$viewModel = new ViewModel(['messages' => $this->flashMessenger()->getMessages(),
			            'categories' => $this->categories]);
	//categories$viewModel->setTerminal(TRUE);
	$viewModel->setTemplate('market/index/default');
	return $viewModel;
    }
}

