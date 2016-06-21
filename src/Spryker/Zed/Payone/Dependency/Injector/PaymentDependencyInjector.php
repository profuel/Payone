<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Dependency\Injector;

use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Dependency\Injector\AbstractDependencyInjector;
use Spryker\Zed\Payment\Dependency\Plugin\Checkout\CheckoutPluginCollection;
use Spryker\Zed\Payment\PaymentDependencyProvider;
use Spryker\Zed\Payone\Communication\Plugin\Checkout\PayonePreCheckPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Checkout\PayoneSaveOrderPlugin;
use Spryker\Zed\Payone\PayoneConfig;

class PaymentDependencyInjector extends AbstractDependencyInjector
{

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function injectBusinessLayerDependencies(Container $container)
    {
        $container = $this->injectPaymentPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function injectPaymentPlugins(Container $container)
    {
        $container->extend(PaymentDependencyProvider::CHECKOUT_PLUGINS, function (CheckoutPluginCollection $pluginCollection) {
            $pluginCollection->add(new PayonePreCheckPlugin(), PayoneConfig::PROVIDER_NAME, PaymentDependencyProvider::CHECKOUT_PRE_CHECK_PLUGINS);
            $pluginCollection->add(new PayoneSaveOrderPlugin(), PayoneConfig::PROVIDER_NAME, PaymentDependencyProvider::CHECKOUT_ORDER_SAVER_PLUGINS);

            return $pluginCollection;
        });

        return $container;
    }

}
