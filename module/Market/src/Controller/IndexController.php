<?php
namespace Market\Controller;

use Model\Traits\ListingsTableTrait;
use Market\Traits\CategoryTrait;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Db\Adapter\Adapter;

class IndexController extends AbstractActionController
{
    use CategoryTrait;    
    use ListingsTableTrait;
    protected $adapter;
    public function indexAction()
    {
		return new ViewModel(['item' => $this->listingsTable->findLatest()]);
	}
    public function queryAction()
    {
        $sql = 'SELECT * FROM `listings` ';
		$results = $this->adapter->query($sql, []);
		$viewModel = new ViewModel(['messages' => $this->flashMessenger()->getMessages(),
									'item' => $item]);
		$viewModel->setTemplate('market/index/default');
		return $viewModel;
    }
    public function setAdapter(Adapter $adapter)
    {
		$this->adapter = $adapter;
		return $this;
    }
}

