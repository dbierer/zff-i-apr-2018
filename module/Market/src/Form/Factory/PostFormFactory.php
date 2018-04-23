<?php
namespace Market\Form\Factory;
use Market\Form\ {PostForm,PostFilter};
use Interop\Container\ContainerInterface;
use Psr\Container\{ContainerExceptionInterface, NotFoundExceptionInterface};
use Zend\ServiceManager\Factory\FactoryInterface;

class PostFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
		try {
			$form = new PostForm($container->get('categories'),
								 $container->get('expire-days'),
								 $container->get('captcha-options'));
			$form->setInputFilter($container->get(PostFilter::class));
        } catch (Exception $e) {
            error_log(__METHOD__ . $e->getMessage());
            $response = $container->get('Response');
            $response->getHeaders()->addHeaderLine('Location', '/');
            $response->setStatusCode(500);
            return $response;
        }
        return $form;
    }
}
