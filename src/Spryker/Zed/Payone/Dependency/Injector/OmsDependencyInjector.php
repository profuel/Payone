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
use Spryker\Zed\Payone\Communication\Plugin\Oms\Command\AuthorizeCommandPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Command\CancelCommandPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Command\CaptureCommandPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Command\CaptureWithSettlementCommandPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Command\PreAuthorizeCommandPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Command\RefundCommandPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\AuthorizationIsApprovedConditionPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\AuthorizationIsErrorConditionPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\AuthorizationIsRedirectConditionPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\CaptureIsApprovedConditionPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PaymentIsAppointedConditionPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PaymentIsCaptureConditionPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PaymentIsOverpaidConditionPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PaymentIsPaidConditionPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PaymentIsRefundConditionPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PaymentIsUnderPaidConditionPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PreAuthorizationIsApprovedConditionPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PreAuthorizationIsErrorConditionPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\PreAuthorizationIsRedirectConditionPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\RefundIsApprovedConditionPlugin;
use Spryker\Zed\Payone\Communication\Plugin\Oms\Condition\RefundIsPossibleConditionPlugin;

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
                ->add(new PreAuthorizeCommandPlugin(), 'Payone/PreAuthorize')
                ->add(new AuthorizeCommandPlugin(), 'Payone/Authorize')
                ->add(new CancelCommandPlugin(), 'Payone/Cancel')
                ->add(new CaptureCommandPlugin(), 'Payone/Capture')
                ->add(new CaptureWithSettlementCommandPlugin(), 'Payone/CaptureWithSettlement')
                ->add(new RefundCommandPlugin(), 'Payone/Refund');

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
                ->add(new PreAuthorizationIsApprovedConditionPlugin(), 'Payone/PreAuthorizationIsApproved')
                ->add(new AuthorizationIsApprovedConditionPlugin(), 'Payone/AuthorizationIsApproved')
                ->add(new CaptureIsApprovedConditionPlugin(), 'Payone/CaptureIsApproved')
                ->add(new RefundIsApprovedConditionPlugin(), 'Payone/RefundIsApproved')
                ->add(new RefundIsPossibleConditionPlugin(), 'Payone/RefundIsPossible')
                ->add(new PreAuthorizationIsErrorConditionPlugin(), 'Payone/PreAuthorizationIsError')
                ->add(new AuthorizationIsErrorConditionPlugin(), 'Payone/AuthorizationIsError')
                ->add(new PreAuthorizationIsRedirectConditionPlugin(), 'Payone/PreAuthorizationIsRedirect')
                ->add(new AuthorizationIsRedirectConditionPlugin(), 'Payone/AuthorizationIsRedirect')
                ->add(new PaymentIsAppointedConditionPlugin(), 'Payone/PaymentIsAppointed')
                ->add(new PaymentIsCaptureConditionPlugin(), 'Payone/PaymentIsCapture')
                ->add(new PaymentIsPaidConditionPlugin(), 'Payone/PaymentIsPaid')
                ->add(new PaymentIsUnderPaidConditionPlugin(), 'Payone/PaymentIsUnderPaid')
                ->add(new PaymentIsOverpaidConditionPlugin(), 'Payone/PaymentIsOverpaid')
                ->add(new PaymentIsRefundConditionPlugin(), 'Payone/PaymentIsRefund');

            return $conditionCollection;
        });

        return $container;
    }

}
