<?php

/**
 * Created by NOC.
 * User: semihs
 * Date: 6.05.2016
 * Time: 15:13
 */

namespace NocVpClient\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use NocVpClient\Service\Exception\ConfigNotFoundException;
use NocVpClient\Service\ProductService;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ProductServiceFactory
 * @package NocVpClient\Factory
 */
class ProductServiceFactory implements  FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');

        if (array_key_exists('noc_vp_client', $config) !== true) {
            throw new ConfigNotFoundException('noc_vp_client not found in your config');
        }

        $subscriptionService = new ProductService($config['noc_vp_client']);
        $subscriptionService->setTokenClient($container->get('NocVp\TokenClient'));

        return $subscriptionService;
    }
}