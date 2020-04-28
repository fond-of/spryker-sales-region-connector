<?php

namespace FondOfSpryker\Zed\SalesRegionConnector\Business\Model;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\SalesRegionConnector\Dependency\Facade\SalesRegionConnectorToCountryFacadeInterface;
use Generated\Shared\Transfer\AddressTransfer;

class SalesOrderAddressHydratorTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\SalesRegionConnector\Dependency\Facade\SalesRegionConnectorToCountryFacadeInterface
     */
    protected $countryFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\AddressTransfer
     */
    protected $addressTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Sales\Persistence\SpySalesOrderAddress
     */
    protected $spySalesOrderAddressMock;

    /**
     * @var \FondOfSpryker\Zed\SalesRegionConnector\Business\Model\SalesOrderAddressHydratorInterface
     */
    protected $salesOrderAddressHydrator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->countryFacadeMock = $this->getMockBuilder(SalesRegionConnectorToCountryFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->addressTransferMock = $this->getMockBuilder(AddressTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spySalesOrderAddressMock = $this->getMockBuilder('\Orm\Zed\Sales\Persistence\SpySalesOrderAddress')
            ->disableOriginalConstructor()
            ->setMethods(['setFkRegion'])
            ->getMock();

        $this->salesOrderAddressHydrator = new SalesOrderAddressHydrator($this->countryFacadeMock);
    }

    /**
     * @return void
     */
    public function testHydrate(): void
    {
        $regionIso2Code = 'NW';
        $fkRegion = 1;

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getRegion')
            ->willReturn($regionIso2Code);

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getFkRegion')
            ->willReturn(null);

        $this->countryFacadeMock->expects($this->atLeastOnce())
            ->method('getIdRegionByIso2Code')
            ->with($regionIso2Code)
            ->willReturn($fkRegion);

        $this->spySalesOrderAddressMock->expects($this->atLeastOnce())
            ->method('setFkRegion')
            ->with($fkRegion)
            ->willReturn($this->spySalesOrderAddressMock);

        $spySalesOrderAddress = $this->salesOrderAddressHydrator->hydrate(
            $this->addressTransferMock,
            $this->spySalesOrderAddressMock
        );

        $this->assertEquals($this->spySalesOrderAddressMock, $spySalesOrderAddress);
    }

    /**
     * @return void
     */
    public function testHydrateWithAlreadyExistingFkRegion(): void
    {
        $regionIso2Code = 'NW';
        $fkRegion = 1;

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getRegion')
            ->willReturn($regionIso2Code);

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getFkRegion')
            ->willReturn($fkRegion);

        $this->countryFacadeMock->expects($this->never())
            ->method('getIdRegionByIso2Code');

        $this->spySalesOrderAddressMock->expects($this->never())
            ->method('setFkRegion');

        $spySalesOrderAddress = $this->salesOrderAddressHydrator->hydrate(
            $this->addressTransferMock,
            $this->spySalesOrderAddressMock
        );

        $this->assertEquals($this->spySalesOrderAddressMock, $spySalesOrderAddress);
    }

    /**
     * @return void
     */
    public function testHydrateWithoutExistingRegionIso2Code(): void
    {
        $regionIso2Code = null;

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getRegion')
            ->willReturn($regionIso2Code);

        $this->addressTransferMock->expects($this->never())
            ->method('getFkRegion');

        $this->countryFacadeMock->expects($this->never())
            ->method('getIdRegionByIso2Code');

        $this->spySalesOrderAddressMock->expects($this->never())
            ->method('setFkRegion');

        $spySalesOrderAddress = $this->salesOrderAddressHydrator->hydrate(
            $this->addressTransferMock,
            $this->spySalesOrderAddressMock
        );

        $this->assertEquals($this->spySalesOrderAddressMock, $spySalesOrderAddress);
    }
}
