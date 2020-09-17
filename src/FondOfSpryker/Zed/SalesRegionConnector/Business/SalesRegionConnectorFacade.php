<?php

namespace FondOfSpryker\Zed\SalesRegionConnector\Business;

use Generated\Shared\Transfer\AddressTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderAddress;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\SalesRegionConnector\Business\SalesRegionConnectorBusinessFactory getFactory()
 */
class SalesRegionConnectorFacade extends AbstractFacade implements SalesRegionConnectorFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderAddress $salesOrderAddressEntity
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderAddress
     */
    public function hydrateSalesOrderAddress(
        AddressTransfer $addressTransfer,
        SpySalesOrderAddress $salesOrderAddressEntity
    ): SpySalesOrderAddress {
        return $this->getFactory()->createSalesOrderAddressHydrator()->hydrate(
            $addressTransfer,
            $salesOrderAddressEntity
        );
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    public function expandOrderAddressWithRegion(AddressTransfer $addressTransfer): AddressTransfer
    {
        return $this->getFactory()->createOrderAddressExpander()->expandWithRegion($addressTransfer);
    }
}
