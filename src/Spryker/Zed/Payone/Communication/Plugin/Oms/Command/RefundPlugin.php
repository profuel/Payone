<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Communication\Plugin\Oms\Command;

use Generated\Shared\Transfer\PayonePaymentTransfer;
use Generated\Shared\Transfer\PayoneRefundTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Shared\Payone\PayoneApiConstants;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;
use Spryker\Zed\Oms\Communication\Plugin\Oms\Command\CommandByOrderInterface;

/**
 * @method \Spryker\Zed\Payone\Communication\PayoneCommunicationFactory getFactory()
 * @method \Spryker\Zed\Payone\Business\PayoneFacade getFacade()
 */
class RefundPlugin extends AbstractPayonePlugin implements CommandByOrderInterface
{

    /**
     * @param array $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return array Array
     */
    public function run(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data)
    {
        $refundTransfer = new PayoneRefundTransfer();

        $refundAmount = 0;
        foreach ($orderItems as $orderItem) {
            $refundAmount -= $this->getItemTransfer($orderItem)->getRefundableAmount();
        }

        $refundTransfer->setAmount($refundAmount);

        $paymentPayoneEntity = $orderEntity->getSpyPaymentPayones()->getFirst();

        $payonePaymentTransfer = new PayonePaymentTransfer();
        $payonePaymentTransfer->fromArray($paymentPayoneEntity->toArray(), true);

        $refundTransfer->setPayment($payonePaymentTransfer);
        $refundTransfer->setUseCustomerdata(PayoneApiConstants::USE_CUSTOMER_DATA_YES);

        $narrativeText = $this->getFactory()->getConfig()->getNarrativeText($orderItems, $orderEntity, $data);
        $refundTransfer->setNarrativeText($narrativeText);

        $this->getFacade()->refundPayment($refundTransfer);

        return [];
    }

}
