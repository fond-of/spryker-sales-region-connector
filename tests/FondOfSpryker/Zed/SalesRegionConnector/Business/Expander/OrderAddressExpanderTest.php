<?php

namespace FondOfSpryker\Zed\SalesRegionConnector\Business\Expander;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\SalesRegionConnector\Dependency\Facade\SalesRegionConnectorToCountryFacadeInterface;
use Generated\Shared\Transfer\AddressTransfer;

class OrderAddressExpanderTest extends Unit
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
     * @var \FondOfSpryker\Zed\SalesRegionConnector\Business\Expander\OrderAddressExpander
     */
    protected $orderAddressExpander;

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

        $this->orderAddressExpander = new OrderAddressExpander($this->countryFacadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $regionIso2Code = 'NW';
        $fkRegion = 1;

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getRegion')
            ->willReturn($regionIso2Code);

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getFkRegion')
            ->willReturn(null);

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('setFkRegion')
            ->with($fkRegion)
            ->willReturn($this->addressTransferMock);

        $this->countryFacadeMock->expects($this->atLeastOnce())
            ->method('getIdRegionByIso2Code')
            ->with($regionIso2Code)
            ->willReturn($fkRegion);

        $addressTransfer = $this->orderAddressExpander->expandWithRegion(
            $this->addressTransferMock
        );

        $this->assertEquals($this->addressTransferMock, $addressTransfer);
    }

    /**
     * @return void
     */
    public function testExpandWithAlreadyExistingFkRegion(): void
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

        $this->addressTransferMock->expects($this->never())
            ->method('setFkRegion');

        $addressTransfer = $this->orderAddressExpander->expandWithRegion(
            $this->addressTransferMock
        );

        $this->assertEquals($this->addressTransferMock, $addressTransfer);
    }

    /**
     * @return void
     */
    public function testExpandWithoutExistingRegionIso2Code(): void
    {
        $regionIso2Code = null;

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getRegion')
            ->willReturn($regionIso2Code);

        $this->addressTransferMock->expects($this->never())
            ->method('getFkRegion');

        $this->countryFacadeMock->expects($this->never())
            ->method('getIdRegionByIso2Code');

        $this->addressTransferMock->expects($this->never())
            ->method('setFkRegion');

        $addressTransfer = $this->orderAddressExpander->expandWithRegion(
            $this->addressTransferMock
        );

        $this->assertEquals($this->addressTransferMock, $addressTransfer);
    }
}
