<?php

namespace FondOfSpryker\Zed\SalesRegionConnector\Dependency\Facade;

use FondOfSpryker\Zed\Country\Business\CountryFacadeInterface;

class SalesRegionConnectorToCountryFacadeBridge implements SalesRegionConnectorToCountryFacadeInterface
{
    /**
     * @var \FondOfSpryker\Zed\Country\Business\CountryFacadeInterface
     */
    protected $countryFacade;

    /**
     * @param \FondOfSpryker\Zed\Country\Business\CountryFacadeInterface $countryFacade
     */
    public function __construct(CountryFacadeInterface $countryFacade)
    {
        $this->countryFacade = $countryFacade;
    }

    /**
     * @param string $iso2code
     *
     * @return int
     */
    public function getIdRegionByIso2Code(string $iso2code): int
    {
        return $this->countryFacade->getIdRegionByIso2Code($iso2code);
    }
}
