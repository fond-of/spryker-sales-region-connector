<?php

namespace FondOfSpryker\Zed\SalesRegionConnector\Business\Expander;

use Generated\Shared\Transfer\AddressTransfer;

interface OrderAddressExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    public function expandWithRegion(AddressTransfer $addressTransfer): AddressTransfer;
}
