<?php

namespace FondOfSpryker\Zed\SalesRegionConnector\Communication\Plugin\SalesExtension;

use FondOfSpryker\Zed\SalesExtension\Dependency\Plugin\OrderAddressExpanderPluginInterface;
use Generated\Shared\Transfer\AddressTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\SalesRegionConnector\Business\SalesRegionConnectorFacadeInterface getFacade()
 */
class RegionOrderAddressExpanderPlugin extends AbstractPlugin implements OrderAddressExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    public function expand(AddressTransfer $addressTransfer): AddressTransfer
    {
        return $this->getFacade()->expandOrderAddressWithRegion($addressTransfer);
    }
}
