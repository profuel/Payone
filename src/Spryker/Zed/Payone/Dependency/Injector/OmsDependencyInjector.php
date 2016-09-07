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
use Spryker\Zed\Payone\Communication\Plugin\Oms\Command\AuthorizePlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Command\CancelPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Command\CapturePlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Command\CaptureWithSettlementPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Command\PreAuthorizePlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Command\RefundPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\AuthorizationIsApprovedPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\AuthorizationIsErrorPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\AuthorizationIsRedirectPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\CaptureIsApprovedPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PaymentIsAppointed;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PaymentIsCapture;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PaymentIsOverpaid;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PaymentIsPaid;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PaymentIsRefund;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PaymentIsUnderPaid;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PreAuthorizationIsApprovedPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PreAuthorizationIsErrorPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PreAuthorizationIsRedirectPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\RefundIsApprovedPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\RefundIsPossiblePlugin;

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
                ->add(new AuthorizePlugin(), 'Payone/Authorize')
                ->add(new CancelPlugin(), 'Payone/Cancel')
                ->add(new CapturePlugin(), 'Payone/Capture')
                ->add(new CaptureWithSettlementPlugin(), 'Payone/CaptureWithSettlement')
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
                ->add(new PreAuthorizationIsApprovedPlugin(), 'Payone/PreAuthorizationIsApprovedPlugin')
                ->add(new AuthorizationIsApprovedPlugin(), 'Payone/AuthorizationIsApprovedPlugin')
                ->add(new CaptureIsApprovedPlugin(), 'Payone/CaptureIsApprovedPlugin')
                ->add(new RefundIsApprovedPlugin(), 'Payone/RefundIsApprovedPlugin')
                ->add(new RefundIsPossiblePlugin(), 'Payone/RefundIsPossiblePlugin')
                ->add(new PreAuthorizationIsErrorPlugin(), 'Payone/PreAuthorizationIsErrorPlugin')
                ->add(new AuthorizationIsErrorPlugin(), 'Payone/AuthorizationIsErrorPlugin')
                ->add(new PreAuthorizationIsRedirectPlugin(), 'Payone/PreAuthorizationIsRedirectPlugin')
                ->add(new AuthorizationIsRedirectPlugin(), 'Payone/AuthorizationIsRedirectPlugin')
                ->add(new PaymentIsAppointed(), 'Payone/PaymentIsAppointed')
                ->add(new PaymentIsCapture(), 'Payone/PaymentIsCapture')
                ->add(new PaymentIsPaid(), 'Payone/PaymentIsPaid')
                ->add(new PaymentIsUnderPaid(), 'Payone/PaymentIsUnderPaid')
                ->add(new PaymentIsOverpaid(), 'Payone/PaymentIsOverpaid')
                ->add(new PaymentIsRefund(), 'Payone/PaymentIsRefund');

            return $conditionCollection;
        });

        return $container;
    }

}
