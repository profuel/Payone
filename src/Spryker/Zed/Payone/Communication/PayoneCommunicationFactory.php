<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Payone\Business\Key\UrlHmacGenerator;
use Spryker\Zed\Payone\PayoneDependencyProvider;

/**
 * @method \Spryker\Zed\Payone\PayoneConfig getConfig()
 * @method \Spryker\Zed\Payone\Persistence\PayoneQueryContainerInterface getQueryContainer()
 */
class PayoneCommunicationFactory extends AbstractCommunicationFactory
{

    /**
     * @return \Spryker\Zed\Payone\Dependency\Facade\PayoneToOmsInterface
     */
    public function getOmsFacade()
    {
        return $this->getProvidedDependency(PayoneDependencyProvider::FACADE_OMS);
    }

    /**
     * @return \Spryker\Zed\Payone\Dependency\Facade\PayoneToSalesInterface
     */
    public function getSalesFacade()
    {
        return $this->getProvidedDependency(PayoneDependencyProvider::FACADE_SALES);
    }

    /**
     * @return \Spryker\Zed\Payone\Dependency\Facade\PayoneToRefundInterface
     */
    public function getRefundFacade()
    {
        return $this->getProvidedDependency(PayoneDependencyProvider::FACADE_REFUND);
    }

    /**
     * @return \Spryker\Zed\Payone\Business\Key\UrlHmacGenerator
     */
    public function createUrlHmacGenerator()
    {
        return new UrlHmacGenerator();
    }

}
