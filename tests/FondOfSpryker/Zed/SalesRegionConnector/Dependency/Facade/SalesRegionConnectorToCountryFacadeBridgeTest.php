<?php

namespace FondOfSpryker\Zed\SalesRegionConnector\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\Country\Business\CountryFacadeInterface;

class SalesRegionConnectorToCountryFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\Country\Business\CountryFacadeInterface
     */
    protected $countryFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\SalesRegionConnector\Dependency\Facade\SalesRegionConnectorToCountryFacadeBridge
     */
    protected $salesRegionConnectorToCountryFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->countryFacadeMock = $this->getMockBuilder(CountryFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesRegionConnectorToCountryFacadeBridge = new SalesRegionConnectorToCountryFacadeBridge(
            $this->countryFacadeMock
        );
    }

    /**
     * @return void
     */
    public function testGetCountryById(): void
    {
        $regionIso2Code = 'NW';
        $fkRegion = 1;

        $this->countryFacadeMock->expects($this->atLeastOnce())
            ->method('getIdRegionByIso2Code')
            ->with($regionIso2Code)
            ->willReturn($fkRegion);

        $this->assertEquals(
            $fkRegion,
            $this->salesRegionConnectorToCountryFacadeBridge->getIdRegionByIso2Code($regionIso2Code)
        );
    }
}
