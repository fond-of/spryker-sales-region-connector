<?php

namespace FondOfSpryker\Zed\SalesRegionConnector\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\SalesRegionConnector\Business\Model\SalesOrderAddressHydratorInterface;
use Generated\Shared\Transfer\AddressTransfer;

class SalesRegionConnectorFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\SalesRegionConnector\Business\SalesRegionConnectorBusinessFactory
     */
    protected $salesRegionConnectorBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\SalesRegionConnector\Business\Model\SalesOrderAddressHydratorInterface
     */
    protected $salesOrderAddressHydratorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Sales\Persistence\SpySalesOrderAddress
     */
    protected $spySalesOrderAddressMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\AddressTransfer
     */
    protected $addressTransferMock;

    /**
     * @var \FondOfSpryker\Zed\SalesRegionConnector\Business\SalesRegionConnectorFacade
     */
    protected $salesRegionConnectorFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->salesRegionConnectorBusinessFactoryMock = $this->getMockBuilder(SalesRegionConnectorBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesOrderAddressHydratorMock = $this->getMockBuilder(SalesOrderAddressHydratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->addressTransferMock = $this->getMockBuilder(AddressTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spySalesOrderAddressMock = $this->getMockBuilder('\Orm\Zed\Sales\Persistence\SpySalesOrderAddress')
            ->disableOriginalConstructor()
            ->setMethods(['setFkRegion'])
            ->getMock();

        $this->salesRegionConnectorFacade = new SalesRegionConnectorFacade();
        $this->salesRegionConnectorFacade->setFactory($this->salesRegionConnectorBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testHydrateSalesOrderAddress(): void
    {
        $this->salesRegionConnectorBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createSalesOrderAddressHydrator')
            ->willReturn($this->salesOrderAddressHydratorMock);

        $this->salesOrderAddressHydratorMock->expects($this->atLeastOnce())
            ->method('hydrate')
            ->with($this->addressTransferMock, $this->spySalesOrderAddressMock)
            ->willReturn($this->spySalesOrderAddressMock);

        $spySalesOrderAddress = $this->salesRegionConnectorFacade->hydrateSalesOrderAddress(
            $this->addressTransferMock,
            $this->spySalesOrderAddressMock
        );

        $this->assertEquals($this->spySalesOrderAddressMock, $spySalesOrderAddress);
    }
}
