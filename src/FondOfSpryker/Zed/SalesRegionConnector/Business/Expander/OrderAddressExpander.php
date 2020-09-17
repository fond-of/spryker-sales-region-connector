<?php

namespace FondOfSpryker\Zed\SalesRegionConnector\Business\Expander;

use FondOfSpryker\Zed\SalesRegionConnector\Dependency\Facade\SalesRegionConnectorToCountryFacadeInterface;
use Generated\Shared\Transfer\AddressTransfer;

class OrderAddressExpander implements OrderAddressExpanderInterface
{
    /**
     * @var \FondOfSpryker\Zed\SalesRegionConnector\Dependency\Facade\SalesRegionConnectorToCountryFacadeInterface
     */
    protected $countryFacade;

    /**
     * @param \FondOfSpryker\Zed\SalesRegionConnector\Dependency\Facade\SalesRegionConnectorToCountryFacadeInterface $countryFacade
     */
    public function __construct(SalesRegionConnectorToCountryFacadeInterface $countryFacade)
    {
        $this->countryFacade = $countryFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    public function expandWithRegion(AddressTransfer $addressTransfer): AddressTransfer
    {
        $regionIso2Code = $addressTransfer->getRegion();

        if ($regionIso2Code === null || $addressTransfer->getFkRegion() !== null) {
            return $addressTransfer;
        }

        $fkRegion = $this->countryFacade->getIdRegionByIso2Code($regionIso2Code);

        return $addressTransfer->setFkRegion($fkRegion);
    }
}
