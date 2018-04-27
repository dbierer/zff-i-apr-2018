<?php
namespace Model\Table;

use Interop\Container\ContainerInterface;
use Psr\Container\{ContainerExceptionInterface, NotFoundExceptionInterface};
use Zend\ServiceManager\Factory\FactoryInterface;

class ListingsFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
		try {
			$table = new Listings(Listings::TABLE_NAME, $container->get('model-primary-adapter'));
        } catch (Exception $e) {
            error_log(__METHOD__ . $e->getMessage());
            $response = $container->get('Response');
            $response->getHeaders()->addHeaderLine('Location', '/');
            $response->setStatusCode(500);
            return $response;
        }
        return $table;
    }
}
