<?php

/*
 * (c) Copyright Spryker Systems GmbH 2015
 */

namespace Spryker\Zed\Payone\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Payone\PayoneConfig;
use Spryker\Zed\Payone\PayoneDependencyProvider;
use Spryker\Zed\Payone\Persistence\PayoneQueryContainerInterface;

/**
 * @method PayoneConfig getConfig()
 * @method PayoneQueryContainerInterface getQueryContainer()
 */
class PayoneCommunicationFactory extends AbstractCommunicationFactory
{

    /**
     * @deprecated Use getOmsFacade() instead.
     *
     * @return \Spryker\Zed\Payone\Dependency\Facade\PayoneToOmsInterface
     */
    public function createOmsFacade()
    {
        trigger_error('Deprecated, use getOmsFacade() instead.', E_USER_DEPRECATED);

        return $this->getOmsFacade();
    }

    /**
     * @return \Spryker\Zed\Payone\Dependency\Facade\PayoneToOmsInterface
     */
    public function getOmsFacade()
    {
        return $this->getProvidedDependency(PayoneDependencyProvider::FACADE_OMS);
    }

    /**
     * @deprecated Use getRefundFacade() instead.
     *
     * @return \Spryker\Zed\Payone\Dependency\Facade\PayoneToRefundInterface
     */
    public function createRefundFacade()
    {
        trigger_error('Deprecated, use getRefundFacade() instead.', E_USER_DEPRECATED);

        return $this->getRefundFacade();
    }

    /**
     * @return \Spryker\Zed\Payone\Dependency\Facade\PayoneToRefundInterface
     */
    public function getRefundFacade()
    {
        return $this->getProvidedDependency(PayoneDependencyProvider::FACADE_REFUND);
    }

}
