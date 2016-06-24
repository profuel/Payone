<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Communication\Controller;

use Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItemQuery;
use Spryker\Shared\Payone\PayoneConstants;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;
use Spryker\Zed\Payone\Business\Api\TransactionStatus\TransactionStatusResponse;

/**
 * @method \Spryker\Zed\Payone\Business\PayoneFacade getFacade()
 * @method \Spryker\Zed\Payone\Communication\PayoneCommunicationFactory getFactory()
 */
class GatewayController extends AbstractGatewayController
{

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function statusUpdateAction(PayoneTransactionStatusUpdateTransfer $transactionStatus)
    {
        $response = $this->getFacade()->processTransactionStatusUpdate($transactionStatus);

        $transactionId = $transactionStatus->getTxid();
        $this->triggerEventsOnSuccess($response, $transactionId, $transactionStatus->toArray());

        return $transactionStatus;
    }

    /**
     * @param \Spryker\Zed\Payone\Business\Api\TransactionStatus\TransactionStatusResponse $response
     * @param int $transactionId
     * @param array $dataArray
     *
     * @return void
     */
    protected function triggerEventsOnSuccess(TransactionStatusResponse $response, $transactionId, array $dataArray)
    {
        if (!$response->isSuccess()) {
            return;
        }

        //TODO: Refactor as per CD-380
        $orderItems = SpySalesOrderItemQuery::create()
            ->useOrderQuery()
            ->useSpyPaymentPayoneQuery()
            ->filterByTransactionId($transactionId)
            ->endUse()
            ->endUse()
            ->find();
        $this->getFactory()->getOmsFacade()->triggerEvent('PaymentNotificationReceived', $orderItems, []);

        if ($dataArray['txaction'] === PayoneConstants::PAYONE_TXACTION_APPOINTED) {
            $this->getFactory()->getOmsFacade()->triggerEvent('RedirectResponseAppointed', $orderItems, []);
        }
    }

}
