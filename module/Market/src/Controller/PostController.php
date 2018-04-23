<?php
namespace Market\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class PostController extends AbstractActionController
{
	protected $postForm;
	public function __construct($form)
	{
		$this->postForm = $form;
	}
    public function indexAction()
    {
		$data = [];
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $this->postForm->setData($data);
            if ($this->postForm->isValid()) {
                $this->flashMessenger()->addMessage('Success!');
                return $this->redirect()->toRoute('home');
            }
            // otherwise, if not valid, redisplay the populated form
        }
        return new ViewModel(['postForm' => $this->postForm,'data' => $data]);
    }
}

