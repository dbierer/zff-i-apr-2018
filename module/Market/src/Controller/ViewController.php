<?php
namespace Market\Controller;

use Model\Traits\ListingsTableTrait;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class ViewController extends AbstractActionController
{
	use ListingsTableTrait;
    public function indexAction()
    {
		$category = $this->params()->fromRoute('category', FALSE);
		if (!$category) {
			$this->flashMessenger()->addMessage('No Category Found');
			return $this->redirect()->toRoute('market');
		}
		return new ViewModel(['category' => $category, 'listing' => $this->listingsTable->findByCategory($category)]);
    }
    // TODO: add itemAction() which captures "itemId"
    public function itemAction()
    {
		$itemId = $this->params()->fromRoute('itemId', FALSE);
		if (!$itemId) {
			$this->flashMessenger()->addMessage('No itemId Found');
			return $this->redirect()->toRoute('market');
		}
		return new ViewModel(['item' => $this->listingsTable->findById($itemId)]);
    }
}

