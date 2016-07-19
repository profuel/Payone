<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Payone\Zed;

use Generated\Shared\Transfer\PayoneBankAccountCheckTransfer;
use Generated\Shared\Transfer\PayoneManageMandateTransfer;
use Generated\Shared\Transfer\PayonePaymentDirectDebitTransfer;
use Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer;
use Spryker\Client\ZedRequest\Stub\BaseStub;

class PayoneStub extends BaseStub
{

    /**
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
     *
     * @return \Generated\Shared\Transfer\PayonePaymentDirectDebitTransfer
     */
    public function bankAccountCheck(PayonePaymentDirectDebitTransfer $directDebitTransfer)
    {
        $bankAccountCheckTransfer = new PayoneBankAccountCheckTransfer();
        $bankAccountCheckTransfer->setBic($directDebitTransfer->getBic());
        $bankAccountCheckTransfer->setIban($directDebitTransfer->getIban());
        $result = $this->zedStub->call(
            '/payone/gateway/bank-account-check',
            $bankAccountCheckTransfer
        );
        return $result;
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

}
