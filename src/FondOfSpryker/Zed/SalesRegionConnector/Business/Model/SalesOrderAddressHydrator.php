<?php

namespace FondOfSpryker\Zed\SalesRegionConnector\Business\Model;

use FondOfSpryker\Zed\SalesRegionConnector\Dependency\Facade\SalesRegionConnectorToCountryFacadeInterface;
use Generated\Shared\Transfer\AddressTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderAddress;

class SalesOrderAddressHydrator implements SalesOrderAddressHydratorInterface
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
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderAddress $salesOrderAddressEntity
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderAddress
     */
    public function hydrate(
        AddressTransfer $addressTransfer,
        SpySalesOrderAddress $salesOrderAddressEntity
    ): SpySalesOrderAddress {
        $regionIso2Code = $addressTransfer->getRegion();

        if ($regionIso2Code === null || $addressTransfer->getFkRegion() !== null) {
            return $salesOrderAddressEntity;
        }

        $fkRegion = $this->countryFacade->getIdRegionByIso2Code($regionIso2Code);

        return $salesOrderAddressEntity->setFkRegion($fkRegion);
    }
}
