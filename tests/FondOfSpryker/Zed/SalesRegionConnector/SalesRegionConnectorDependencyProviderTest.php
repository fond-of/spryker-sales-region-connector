<?php

namespace FondOfSpryker\Zed\SalesRegionConnector;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\Country\Business\CountryFacadeInterface;
use FondOfSpryker\Zed\SalesRegionConnector\Dependency\Facade\SalesRegionConnectorToCountryFacadeBridge;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Locator;

class SalesRegionConnectorDependencyProviderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Locator
     */
    protected $locatorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\BundleProxy
     */
    protected $bundleProxyMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\Country\Business\CountryFacadeInterface
     */
    protected $countryFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\SalesLocaleConnector\SalesLocaleConnectorDependencyProvider
     */
    protected $salesRegionConnectorDependencyProvider;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->setMethodsExcept(['factory', 'set', 'offsetSet', 'get', 'offsetGet'])
            ->getMock();

        $this->locatorMock = $this->getMockBuilder(Locator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bundleProxyMock = $this->getMockBuilder(BundleProxy::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->countryFacadeMock = $this->getMockBuilder(CountryFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesRegionConnectorDependencyProvider = new SalesRegionConnectorDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects($this->atLeastOnce())
            ->method('__call')
            ->with('country')
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects($this->atLeastOnce())
            ->method('__call')
            ->with('facade')
            ->willReturn($this->countryFacadeMock);

        $container = $this->salesRegionConnectorDependencyProvider->provideBusinessLayerDependencies(
            $this->containerMock
        );

        $this->assertEquals($this->containerMock, $container);
        $this->assertInstanceOf(
            SalesRegionConnectorToCountryFacadeBridge::class,
            $container[SalesRegionConnectorDependencyProvider::FACADE_COUNTRY]
        );
    }
}
