<?php

namespace FondOfSpryker\Zed\SalesRegionConnector\Communication\Plugin\SalesExtension;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\SalesRegionConnector\Business\SalesRegionConnectorFacade;
use Generated\Shared\Transfer\AddressTransfer;

class RegionSalesOrderAddressHydrationPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\SalesRegionConnector\Business\SalesRegionConnectorFacade
     */
    protected $salesRegionConnectorFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Sales\Persistence\SpySalesOrderAddress
     */
    protected $spySalesOrderAddressMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\AddressTransfer
     */
    protected $addressTransferMock;

    /**
     * @var \FondOfSpryker\Zed\SalesRegionConnector\Communication\Plugin\SalesExtension\RegionSalesOrderAddressHydrationPlugin
     */
    protected $regionSalesOrderAddressHydrationPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->salesRegionConnectorFacadeMock = $this->getMockBuilder(SalesRegionConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spySalesOrderAddressMock = $this->getMockBuilder('\Orm\Zed\Sales\Persistence\SpySalesOrderAddress')
            ->disableOriginalConstructor()
            ->getMock();

        $this->addressTransferMock = $this->getMockBuilder(AddressTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->regionSalesOrderAddressHydrationPlugin = new RegionSalesOrderAddressHydrationPlugin();
        $this->regionSalesOrderAddressHydrationPlugin->setFacade($this->salesRegionConnectorFacadeMock);
    }

    /**
     * @return void
     */
    public function testHydrate(): void
    {
        $this->salesRegionConnectorFacadeMock->expects($this->atLeastOnce())
            ->method('hydrateSalesOrderAddress')
            ->with($this->addressTransferMock, $this->spySalesOrderAddressMock)
            ->willReturn($this->spySalesOrderAddressMock);

        $spySalesOrderAddress = $this->regionSalesOrderAddressHydrationPlugin->hydrate(
            $this->addressTransferMock,
            $this->spySalesOrderAddressMock
        );

        $this->assertEquals($this->spySalesOrderAddressMock, $spySalesOrderAddress);
    }
}
