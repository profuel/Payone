<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Communication\Controller;

use Generated\Shared\Transfer\PayoneBankAccountCheckTransfer;
use Generated\Shared\Transfer\PayoneCancelRedirectTransfer;
use Generated\Shared\Transfer\PayoneGetFileTransfer;
use Generated\Shared\Transfer\PayoneManageMandateTransfer;
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
     * @param \Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer $transactionStatus
     *
     * @return \Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer
     */
    public function statusUpdateAction(PayoneTransactionStatusUpdateTransfer $transactionStatus)
    {
        $response = $this->getFacade()->processTransactionStatusUpdate($transactionStatus);

        $transactionId = $transactionStatus->getTxid();
        $this->triggerEventsOnSuccess($response, $transactionId, $transactionStatus->toArray());
        $transactionStatus->setResponse($response->getStatus());

        return $transactionStatus;
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

        if ($cancelRedirectTransfer->getUrlHmac() == $hash) {
            $orderItems = SpySalesOrderItemQuery::create()
                ->useOrderQuery()
                ->filterByOrderReference($cancelRedirectTransfer->getOrderReference())
                ->endUse()
                ->find();

            $this->getFactory()->getOmsFacade()->triggerEvent('RedirectCancelled', $orderItems, []);
        }

        return $cancelRedirectTransfer;
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

    /**
     * @param \Generated\Shared\Transfer\PayoneBankAccountCheckTransfer $bankAccountCheck
     *
     * @return \Generated\Shared\Transfer\PayoneBankAccountCheckTransfer
     */
    public function bankAccountCheckAction(PayoneBankAccountCheckTransfer $bankAccountCheck)
    {
        $response = $this->getFacade()->bankAccountCheck($bankAccountCheck);
        $bankAccountCheck->setErrorCode($response->getErrorcode());
        $bankAccountCheck->setCustomerErrorMessage($response->getCustomermessage());
        $bankAccountCheck->setStatus($response->getStatus());
        $bankAccountCheck->setInternalErrorMessage($response->getErrormessage());
        return $bankAccountCheck;
    }

    /**
     * @param \Generated\Shared\Transfer\PayoneManageMandateTransfer $manageMandateTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneManageMandateTransfer
     */
    public function manageMandateAction(PayoneManageMandateTransfer $manageMandateTransfer)
    {
        $response = $this->getFacade()->manageMandate($manageMandateTransfer);
        $manageMandateTransfer->setErrorCode($response->getErrorcode());
        $manageMandateTransfer->setCustomerErrorMessage($response->getCustomermessage());
        $manageMandateTransfer->setStatus($response->getStatus());
        $manageMandateTransfer->setInternalErrorMessage($response->getErrormessage());
        $manageMandateTransfer->setMandateIdentification($response->getMandateIdentification());
        $manageMandateTransfer->setMandateText($response->getMandateText());
        return $manageMandateTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PayoneGetFileTransfer $getFileTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneGetFileTransfer
     */
    public function getFileAction(PayoneGetFileTransfer $getFileTransfer)
    {
        $response = $this->getFacade()->getFile($getFileTransfer);
        $getFileTransfer->setResponse($response);
        return $getFileTransfer;
    }

}
