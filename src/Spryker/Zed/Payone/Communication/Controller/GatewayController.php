<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Communication\Controller;

use Generated\Shared\Transfer\PayoneBankAccountCheckTransfer;
use Generated\Shared\Transfer\PayoneCancelRedirectTransfer;
use Generated\Shared\Transfer\PayoneGetFileTransfer;
use Generated\Shared\Transfer\PayoneGetInvoiceTransfer;
use Generated\Shared\Transfer\PayoneGetPaymentDetailTransfer;
use Generated\Shared\Transfer\PayoneManageMandateTransfer;
use Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer;
use Orm\Zed\Sales\Persistence\Base\SpySalesOrderQuery;
use Orm\Zed\Sales\Persistence\SpySalesOrderItemQuery;
use Spryker\Shared\Payone\PayoneConstants;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \Spryker\Zed\Payone\Business\PayoneFacade getFacade()
 * @method \Spryker\Zed\Payone\Communication\PayoneCommunicationFactory getFactory()
 */
class GatewayController extends AbstractGatewayController
{

    /**
     * @param \Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer $transactionStatusUpdateTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer
     */
    public function statusUpdateAction(PayoneTransactionStatusUpdateTransfer $transactionStatusUpdateTransfer)
    {
        $transactionStatusUpdateTransfer = $this
            ->getFacade()
            ->processTransactionStatusUpdate($transactionStatusUpdateTransfer);

        $this->triggerEventsOnSuccess($transactionStatusUpdateTransfer);

        return $transactionStatusUpdateTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PayoneCancelRedirectTransfer $cancelRedirectTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneCancelRedirectTransfer
     */
    public function cancelRedirectAction(PayoneCancelRedirectTransfer $cancelRedirectTransfer)
    {
        $urlHmacGenerator = $this->getFactory()->createUrlHmacGenerator();
        $hash = $urlHmacGenerator->hash(
            $cancelRedirectTransfer->getOrderReference(),
            $this->getFactory()->getConfig()->getRequestStandardParameter()->getKey()
        );

        if ($cancelRedirectTransfer->getUrlHmac() === $hash) {
            $orderItems = SpySalesOrderItemQuery::create()
                ->useOrderQuery()
                ->filterByOrderReference($cancelRedirectTransfer->getOrderReference())
                ->endUse()
                ->find();

            $this->getFactory()->getOmsFacade()->triggerEvent('cancel redirect', $orderItems, []);
        }

        return $cancelRedirectTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer $transactionStatusUpdateTransfer
     *
     * @internal param TransactionStatusResponse $response
     *
     * @return void
     */
    protected function triggerEventsOnSuccess(PayoneTransactionStatusUpdateTransfer $transactionStatusUpdateTransfer) {
        if (!$transactionStatusUpdateTransfer->getIsSuccess()) {
            return;
        }

        $orderItems = SpySalesOrderItemQuery::create()
            ->useOrderQuery()
            ->useSpyPaymentPayoneQuery()
            ->filterByTransactionId($transactionStatusUpdateTransfer->getTxid())
            ->endUse()
            ->endUse()
            ->find();
        $this->getFactory()->getOmsFacade()->triggerEvent('PaymentNotificationReceived', $orderItems, []);

        if ($transactionStatusUpdateTransfer->getTxaction() === PayoneConstants::PAYONE_TXACTION_APPOINTED) {
            $this->getFactory()->getOmsFacade()->triggerEvent('RedirectResponseAppointed', $orderItems, []);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\PayoneBankAccountCheckTransfer $bankAccountCheck
     *
     * @return \Generated\Shared\Transfer\PayoneBankAccountCheckTransfer
     */
    public function bankAccountCheckAction(PayoneBankAccountCheckTransfer $bankAccountCheck)
    {
        return $this->getFacade()->bankAccountCheck($bankAccountCheck);
    }

    /**
     * @param \Generated\Shared\Transfer\PayoneManageMandateTransfer $manageMandateTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneManageMandateTransfer
     */
    public function manageMandateAction(PayoneManageMandateTransfer $manageMandateTransfer)
    {
        return $this->getFacade()->manageMandate($manageMandateTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PayoneGetFileTransfer $getFileTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneGetFileTransfer
     */
    public function getFileAction(PayoneGetFileTransfer $getFileTransfer)
    {
        return $this->getFacade()->getFile($getFileTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PayoneGetInvoiceTransfer $getInvoiceTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneGetInvoiceTransfer
     */
    public function getInvoiceAction(PayoneGetInvoiceTransfer $getInvoiceTransfer)
    {
        return $this->getFacade()->getInvoice($getInvoiceTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PayoneGetPaymentDetailTransfer $getPaymentDetailTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneGetPaymentDetailTransfer
     */
    public function getPaymentDetailAction(PayoneGetPaymentDetailTransfer $getPaymentDetailTransfer)
    {
        if (!empty($getPaymentDetailTransfer->getOrderReference())) {
            $order = SpySalesOrderQuery::create()
                ->filterByOrderReference($getPaymentDetailTransfer->getOrderReference())
                ->findOne();
            $getPaymentDetailTransfer->setOrderId($order->getIdSalesOrder());
        }
        $response = $this->getFacade()->getPaymentDetail($getPaymentDetailTransfer->getOrderId());
        $getPaymentDetailTransfer->setPaymentDetail($response);
        return $getPaymentDetailTransfer;
    }

}
