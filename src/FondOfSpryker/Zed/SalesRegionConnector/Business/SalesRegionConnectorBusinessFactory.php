<?php

namespace FondOfSpryker\Zed\SalesRegionConnector\Business;

use FondOfSpryker\Zed\SalesRegionConnector\Business\Expander\OrderAddressExpander;
use FondOfSpryker\Zed\SalesRegionConnector\Business\Expander\OrderAddressExpanderInterface;
use FondOfSpryker\Zed\SalesRegionConnector\Business\Model\SalesOrderAddressHydrator;
use FondOfSpryker\Zed\SalesRegionConnector\Business\Model\SalesOrderAddressHydratorInterface;
use FondOfSpryker\Zed\SalesRegionConnector\Dependency\Facade\SalesRegionConnectorToCountryFacadeInterface;
use FondOfSpryker\Zed\SalesRegionConnector\SalesRegionConnectorDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class SalesRegionConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\SalesRegionConnector\Business\Model\SalesOrderAddressHydratorInterface
     */
    public function createSalesOrderAddressHydrator(): SalesOrderAddressHydratorInterface
    {
        return new SalesOrderAddressHydrator($this->getCountryFacade());
    }

    /**
     * @return \FondOfSpryker\Zed\SalesRegionConnector\Business\Expander\OrderAddressExpanderInterface
     */
    public function createOrderAddressExpander(): OrderAddressExpanderInterface
    {
        return new OrderAddressExpander($this->getCountryFacade());
    }

    /**
     * @return \FondOfSpryker\Zed\SalesRegionConnector\Dependency\Facade\SalesRegionConnectorToCountryFacadeInterface
     */
    protected function getCountryFacade(): SalesRegionConnectorToCountryFacadeInterface
    {
        return $this->getProvidedDependency(SalesRegionConnectorDependencyProvider::FACADE_COUNTRY);
    }
}
