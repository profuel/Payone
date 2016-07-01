<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Dependency\Injector;

use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Dependency\Injector\AbstractDependencyInjector;
use Spryker\Zed\Oms\Communication\Plugin\Oms\Command\CommandCollectionInterface;
use Spryker\Zed\Oms\Communication\Plugin\Oms\Condition\ConditionCollectionInterface;
use Spryker\Zed\Oms\OmsDependencyProvider;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Command\CapturePlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Command\PreAuthorizePlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Command\RefundPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\CaptureIsApprovedPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PaymentIsAppointed;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PaymentIsCapture;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PreauthorizationIsApprovedPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PreauthorizationIsErrorPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PreauthorizationIsRedirectPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\RefundIsApprovedPlugin;

class OmsDependencyInjector extends AbstractDependencyInjector
{

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function injectBusinessLayerDependencies(Container $container)
    {
        $container = $this->injectCommands($container);
        $container = $this->injectConditions($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function injectCommands(Container $container)
    {
        $container->extend(OmsDependencyProvider::COMMAND_PLUGINS, function (CommandCollectionInterface $commandCollection) {
            $commandCollection
                ->add(new PreAuthorizePlugin(), 'Payone/PreAuthorize')
                ->add(new CapturePlugin(), 'Payone/Cancel')
                ->add(new CapturePlugin(), 'Payone/Capture')
                ->add(new RefundPlugin(), 'Payone/Refund');

            return $commandCollection;
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function injectConditions(Container $container)
    {
        $container->extend(OmsDependencyProvider::CONDITION_PLUGINS, function (ConditionCollectionInterface $conditionCollection) {
            $conditionCollection
                ->add(new PreauthorizationIsApprovedPlugin(), 'Payone/PreauthorizationIsApprovedPlugin')
                ->add(new CaptureIsApprovedPlugin(), 'Payone/CaptureIsApprovedPlugin')
                ->add(new RefundIsApprovedPlugin(), 'Payone/RefundIsApprovedPlugin')
                ->add(new PreauthorizationIsErrorPlugin(), 'Payone/PreauthorizationIsErrorPlugin')
                ->add(new PreauthorizationIsRedirectPlugin(), 'Payone/PreauthorizationIsRedirectPlugin')
                ->add(new PaymentIsAppointed(), 'Payone/PaymentIsAppointed')
                ->add(new PaymentIsCapture(), 'Payone/PaymentIsCapture')
                ->add(new PaymentIsCapture(), 'Payone/PaymentIsRefund');

            return $conditionCollection;
        });

        return $container;
    }

}
