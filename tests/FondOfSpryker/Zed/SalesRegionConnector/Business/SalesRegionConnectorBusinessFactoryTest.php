<?php

namespace FondOfSpryker\Zed\SalesRegionConnector\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\SalesRegionConnector\Business\Model\SalesOrderAddressHydrator;
use FondOfSpryker\Zed\SalesRegionConnector\Dependency\Facade\SalesRegionConnectorToCountryFacadeInterface;
use FondOfSpryker\Zed\SalesRegionConnector\SalesRegionConnectorDependencyProvider;
use Spryker\Zed\Kernel\Container;

class SalesRegionConnectorBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\SalesRegionConnector\Dependency\Facade\SalesRegionConnectorToCountryFacadeInterface
     */
    protected $countryFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\SalesRegionConnector\Business\SalesRegionConnectorBusinessFactory
     */
    protected $salesLocaleConnectorBusinessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->countryFacadeMock = $this->getMockBuilder(SalesRegionConnectorToCountryFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesLocaleConnectorBusinessFactory = new SalesRegionConnectorBusinessFactory();
        $this->salesLocaleConnectorBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateSalesOrderAddressHydrator(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(SalesRegionConnectorDependencyProvider::FACADE_COUNTRY)
            ->willReturn($this->countryFacadeMock);

        $orderExpander = $this->salesLocaleConnectorBusinessFactory->createSalesOrderAddressHydrator();

        $this->assertInstanceOf(SalesOrderAddressHydrator::class, $orderExpander);
    }
}
