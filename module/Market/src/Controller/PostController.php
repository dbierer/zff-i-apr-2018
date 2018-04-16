<?php
namespace Market\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class PostController extends AbstractActionController
{
    public function indexAction()
    {
	return new ViewModel();
    }
}

