<?php
namespace Market\Controller;

use Market\Traits\CategoryTrait;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Db\Adapter\Adapter;

class IndexController extends AbstractActionController
{
    use CategoryTrait;    
    protected $adapter;
    public function indexAction()
    {
        $sql = 'SELECT * FROM `listings`';
		$results = $this->adapter->query($sql, []);
		$viewModel = new ViewModel(['messages' => $this->flashMessenger()->getMessages(),
									'categories' => $this->categories,
									'results' => $results]);
		//categories$viewModel->setTerminal(TRUE);
		$viewModel->setTemplate('market/index/index');
		return $viewModel;
    }
    public function setAdapter(Adapter $adapter)
    {
		$this->adapter = $adapter;
		return $this;
    }
}

