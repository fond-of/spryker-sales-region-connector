<?php

namespace FondOfSpryker\Zed\SalesRegionConnector\Dependency\Facade;

interface SalesRegionConnectorToCountryFacadeInterface
{
    /**
     * @param string $iso2code
     *
     * @return int
     */
    public function getIdRegionByIso2Code(string $iso2code): int;
}
