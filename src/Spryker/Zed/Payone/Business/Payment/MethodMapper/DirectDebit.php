<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Business\Payment\MethodMapper;

use Generated\Shared\Transfer\PayoneBankAccountCheckTransfer;
use Generated\Shared\Transfer\PayoneManageMandateTransfer;
use Orm\Zed\Payone\Persistence\SpyPaymentPayone;
use Spryker\Shared\Payone\PayoneApiConstants;
use Spryker\Zed\Payone\Business\Api\Request\Container\AuthorizationContainer;
use Spryker\Zed\Payone\Business\Api\Request\Container\BankAccountCheckContainer;
use Spryker\Zed\Payone\Business\Api\Request\Container\CaptureContainer;
use Spryker\Zed\Payone\Business\Api\Request\Container\DebitContainer;
use Spryker\Zed\Payone\Business\Api\Request\Container\ManageMandateContainer;
use Spryker\Zed\Payone\Business\Api\Request\Container\PreAuthorizationContainer;
use Spryker\Zed\Payone\Business\Api\Request\Container\RefundContainer;

class DirectDebit extends AbstractMapper
{

    /**
     * @return string
     */
    public function getName()
    {
        return PayoneApiConstants::PAYMENT_METHOD_DIRECT_DEBIT;
    }

    /**
     * @param \Orm\Zed\Payone\Persistence\SpyPaymentPayone $paymentEntity
     *
     * @return \Spryker\Zed\Payone\Business\Api\Request\Container\AuthorizationContainer
     */
    public function mapPaymentToAuthorization(SpyPaymentPayone $paymentEntity)
    {
        $authorizationContainer = new AuthorizationContainer();

        return $authorizationContainer;
    }

    /**
     * @param \Orm\Zed\Payone\Persistence\SpyPaymentPayone $paymentEntity
     *
     * @return \Spryker\Zed\Payone\Business\Api\Request\Container\RefundContainer
     */
    public function mapPaymentToRefund(SpyPaymentPayone $paymentEntity)
    {
        $refundContainer = new RefundContainer();

        $refundContainer->setTxid($paymentEntity->getTransactionId());
        $refundContainer->setSequenceNumber($this->getNextSequenceNumber($paymentEntity->getTransactionId()));
        $refundContainer->setCurrency($this->getStandardParameter()->getCurrency());

        return $refundContainer;
    }

    /**
     * @param \Orm\Zed\Payone\Persistence\SpyPaymentPayone $paymentEntity
     *
     * @return \Spryker\Zed\Payone\Business\Api\Request\Container\PreAuthorizationContainer
     */
    public function mapPaymentToPreAuthorization(SpyPaymentPayone $paymentEntity)
    {
        $preAuthorizationContainer = new PreAuthorizationContainer();

        return $preAuthorizationContainer;
    }

    /**
     * @param \Orm\Zed\Payone\Persistence\SpyPaymentPayone $paymentEntity
     *
     * @return \Spryker\Zed\Payone\Business\Api\Request\Container\CaptureContainer
     */
    public function mapPaymentToCapture(SpyPaymentPayone $paymentEntity)
    {
        $paymentDetailEntity = $paymentEntity->getSpyPaymentPayoneDetail();

        $captureContainer = new CaptureContainer();
        $captureContainer->setAmount($paymentDetailEntity->getAmount());
        $captureContainer->setCurrency($this->getStandardParameter()->getCurrency());
        $captureContainer->setTxid($paymentEntity->getTransactionId());
        $captureContainer->setSequenceNumber($this->getNextSequenceNumber($paymentEntity->getTransactionId()));

        return $captureContainer;
    }

    /**
     * @param \Orm\Zed\Payone\Persistence\SpyPaymentPayone $paymentEntity
     *
     * @return \Spryker\Zed\Payone\Business\Api\Request\Container\DebitContainer
     */
    public function mapPaymentToDebit(SpyPaymentPayone $paymentEntity)
    {
        $debitContainer = new DebitContainer();

        $debitContainer->setTxid($paymentEntity->getTransactionId());
        $debitContainer->setSequenceNumber($this->getNextSequenceNumber($paymentEntity->getTransactionId()));
        $debitContainer->setCurrency($this->getStandardParameter()->getCurrency());
        $debitContainer->setAmount($paymentEntity->getSpyPaymentPayoneDetail()->getAmount());

        return $debitContainer;
    }

    public function mapBankAccountCheck(PayoneBankAccountCheckTransfer $bankAccountCheckTransfer)
    {
        $bankAccountCheckContainer = new BankAccountCheckContainer();

        $bankAccountCheckContainer->setAid($this->getStandardParameter()->getAid());
        $bankAccountCheckContainer->setIban($bankAccountCheckTransfer->getIban());
        $bankAccountCheckContainer->setBic($bankAccountCheckTransfer->getBic());

        return $bankAccountCheckContainer;
    }

    public function mapManageMandate(PayoneManageMandateTransfer $manageMandateTransfer)
    {
        $manageMandateContainer = new ManageMandateContainer();

        $manageMandateContainer->setAid($this->getStandardParameter()->getAid());
        $manageMandateContainer->setClearingType(PayoneApiConstants::CLEARING_TYPE_DIRECT_DEBIT);
        $manageMandateContainer->setCurrency($this->getStandardParameter()->getCurrency());
        $manageMandateContainer->setCustomerid($manageMandateTransfer->getPersonalData()->getCustomerId());
        $manageMandateContainer->setLastname($manageMandateTransfer->getPersonalData()->getLastName());
        $manageMandateContainer->setCity($manageMandateTransfer->getPersonalData()->getCity());
        $manageMandateContainer->setCountry($manageMandateTransfer->getPersonalData()->getCountry());
        $manageMandateContainer->setEmail($manageMandateTransfer->getPersonalData()->getEmail());

        $manageMandateContainer->setIban($manageMandateTransfer->getIban());
        $manageMandateContainer->setBic($manageMandateTransfer->getBic());

        return $manageMandateContainer;
    }

}
