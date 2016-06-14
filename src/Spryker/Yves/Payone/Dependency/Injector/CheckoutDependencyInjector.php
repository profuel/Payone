<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Dependency\Injector;

use Generated\Shared\Transfer\PaymentTransfer;
use Spryker\Shared\Kernel\ContainerInterface;
use Spryker\Yves\Checkout\CheckoutDependencyProvider;
use Spryker\Yves\Kernel\Dependency\Injector\AbstractDependencyInjector;
use Spryker\Yves\Payone\Plugin\PayoneHandlerPlugin;
use Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginCollection;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginCollection;

/**
 * @method \Spryker\Yves\Payone\PayoneFactory getFactory()
 */
class CheckoutDependencyInjector extends AbstractDependencyInjector
{

    /**
     * @param \Spryker\Shared\Kernel\ContainerInterface|\Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Shared\Kernel\ContainerInterface|\Spryker\Yves\Kernel\Container
     */
    public function inject(ContainerInterface $container)
    {
        $container->extend(CheckoutDependencyProvider::PAYMENT_SUB_FORMS, function (SubFormPluginCollection $paymentSubForms) {
            $paymentSubForms->add($this->getFactory()->createPrePaymentSubFormPlugin());
            $paymentSubForms->add($this->getFactory()->createCreditCardSubFormPlugin());

            return $paymentSubForms;
        });

        $container->extend(CheckoutDependencyProvider::PAYMENT_METHOD_HANDLER, function (StepHandlerPluginCollection $paymentMethodHandler) {
            $paymentMethodHandler->add(new PayoneHandlerPlugin(), PaymentTransfer::PAYONE_PRE_PAYMENT);

            return $paymentMethodHandler;
        });

        return $container;
    }

}
