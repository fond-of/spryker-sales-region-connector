<?php

namespace FondOfSpryker\Zed\SalesRegionConnector\Communication\Plugin\SalesExtension;

use FondOfSpryker\Zed\Sales\Dependency\Plugin\SalesOrderAddressHydrationPluginInterface;
use Generated\Shared\Transfer\AddressTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderAddress;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\SalesRegionConnector\Business\SalesRegionConnectorFacadeInterface getFacade()
 */
class RegionSalesOrderAddressHydrationPlugin extends AbstractPlugin implements SalesOrderAddressHydrationPluginInterface
{
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
        return $this->getFacade()->hydrateSalesOrderAddress($addressTransfer, $salesOrderAddressEntity);
    }
}
