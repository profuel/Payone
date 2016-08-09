<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Payone\Zed;

use Generated\Shared\Transfer\PayoneBankAccountCheckTransfer;
use Generated\Shared\Transfer\PayoneCancelRedirectTransfer;
use Generated\Shared\Transfer\PayoneGetFileTransfer;
use Generated\Shared\Transfer\PayoneGetPaymentDetailTransfer;
use Generated\Shared\Transfer\PayoneManageMandateTransfer;
use Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer;
use Spryker\Client\ZedRequest\Stub\BaseStub;

class PayoneStub extends BaseStub
{

    /**
     * @param \Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer $transactionStatus
     *
     * @return \Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer
     */
    public function updateStatus(PayoneTransactionStatusUpdateTransfer $transactionStatus)
    {
        return $this->zedStub->call(
            '/payone/gateway/status-update',
            $transactionStatus
        );
    }

    /**
     * @param \Generated\Shared\Transfer\PayoneBankAccountCheckTransfer $bankAccountCheckTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneBankAccountCheckTransfer
     */
    public function bankAccountCheck(PayoneBankAccountCheckTransfer $bankAccountCheckTransfer)
    {
        return $this->zedStub->call(
            '/payone/gateway/bank-account-check',
            $bankAccountCheckTransfer
        );
    }

    /**
     * @param \Generated\Shared\Transfer\PayoneManageMandateTransfer $manageMandateTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneManageMandateTransfer
     */
    public function manageMandate(PayoneManageMandateTransfer $manageMandateTransfer)
    {
        return $this->zedStub->call(
            '/payone/gateway/manage-mandate',
            $manageMandateTransfer
        );
    }

    /**
     * @param \Generated\Shared\Transfer\PayoneGetFileTransfer $getFileTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneGetFileTransfer
     */
    public function getFile(PayoneGetFileTransfer $getFileTransfer)
    {
        return $this->zedStub->call(
            '/payone/gateway/get-file',
            $getFileTransfer
        );
    }

    /**
    * @param \Generated\Shared\Transfer\PayoneGetPaymentDetailTransfer $getPaymentDetailTransfer
    *
    * @return \Generated\Shared\Transfer\PayoneGetPaymentDetailTransfer
    */
    public function getPaymentDetail(PayoneGetPaymentDetailTransfer $getPaymentDetailTransfer)
    {
        return $this->zedStub->call(
            '/payone/gateway/get-payment-detail',
            $getPaymentDetailTransfer
        );
    }

    /**
     * @param \Generated\Shared\Transfer\PayoneCancelRedirectTransfer $cancelRedirectTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneCancelRedirectTransfer
     */
    public function cancelRedirect(PayoneCancelRedirectTransfer $cancelRedirectTransfer)
    {
        return $this->zedStub->call(
            '/payone/gateway/cancel-redirect',
            $cancelRedirectTransfer
        );
    }

}
