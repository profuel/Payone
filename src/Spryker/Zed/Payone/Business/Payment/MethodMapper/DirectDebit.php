<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payone\Business\Payment\MethodMapper;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PayoneBankAccountCheckTransfer;
use Generated\Shared\Transfer\PayoneGetFileTransfer;
use Generated\Shared\Transfer\PayoneManageMandateTransfer;
use Orm\Zed\Payone\Persistence\SpyPaymentPayone;
use Spryker\Shared\Payone\PayoneApiConstants;
use Spryker\Zed\Payone\Business\Api\Request\Container\AuthorizationContainer;
use Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\AbstractAuthorizationContainer;
use Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\PaymentMethod\DirectDebitContainer;
use Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\PersonalContainer;
use Spryker\Zed\Payone\Business\Api\Request\Container\BankAccountCheckContainer;
use Spryker\Zed\Payone\Business\Api\Request\Container\CaptureContainer;
use Spryker\Zed\Payone\Business\Api\Request\Container\DebitContainer;
use Spryker\Zed\Payone\Business\Api\Request\Container\GetFileContainer;
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
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Spryker\Zed\Payone\Business\Api\Request\Container\AuthorizationContainer
     */
    public function mapPaymentToAuthorization(SpyPaymentPayone $paymentEntity, OrderTransfer $orderTransfer)
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
        $preAuthorizationContainer = $this->mapPaymentToAbstractAuthorization($paymentEntity, $preAuthorizationContainer);

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

    /**
     * @param \Generated\Shared\Transfer\PayoneBankAccountCheckTransfer $bankAccountCheckTransfer
     *
     * @return \Spryker\Zed\Payone\Business\Api\Request\Container\BankAccountCheckContainer
     */
    public function mapBankAccountCheck(PayoneBankAccountCheckTransfer $bankAccountCheckTransfer)
    {
        $bankAccountCheckContainer = new BankAccountCheckContainer();

        $bankAccountCheckContainer->setAid($this->getStandardParameter()->getAid());
        $bankAccountCheckContainer->setBankCountry($bankAccountCheckTransfer->getBankCountry());
        $bankAccountCheckContainer->setBankAccount($bankAccountCheckTransfer->getBankAccount());
        $bankAccountCheckContainer->setBankCode($bankAccountCheckTransfer->getBankCode());
        $bankAccountCheckContainer->setIban($bankAccountCheckTransfer->getIban());
        $bankAccountCheckContainer->setBic($bankAccountCheckTransfer->getBic());

        return $bankAccountCheckContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\PayoneManageMandateTransfer $manageMandateTransfer
     *
     * @return \Spryker\Zed\Payone\Business\Api\Request\Container\ManageMandateContainer
     */
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
        $manageMandateContainer->setLanguage($this->getStandardParameter()->getLanguage());

        $manageMandateContainer->setIban($manageMandateTransfer->getIban());
        $manageMandateContainer->setBic($manageMandateTransfer->getBic());

        return $manageMandateContainer;
    }

    /**
     * @param \Orm\Zed\Payone\Persistence\SpyPaymentPayone $paymentEntity
     * @param \Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\AbstractAuthorizationContainer $authorizationContainer
     *
     * @return \Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\AbstractAuthorizationContainer
     */
    protected function mapPaymentToAbstractAuthorization(SpyPaymentPayone $paymentEntity, AbstractAuthorizationContainer $authorizationContainer)
    {
        $paymentDetailEntity = $paymentEntity->getSpyPaymentPayoneDetail();

        $authorizationContainer->setAid($this->getStandardParameter()->getAid());
        $authorizationContainer->setClearingType(PayoneApiConstants::CLEARING_TYPE_DIRECT_DEBIT);
        $authorizationContainer->setReference($paymentEntity->getReference());
        $authorizationContainer->setAmount($paymentDetailEntity->getAmount());
        $authorizationContainer->setCurrency($this->getStandardParameter()->getCurrency());
        $authorizationContainer->setPaymentMethod($this->createPaymentMethodContainerFromPayment($paymentEntity));

        $billingAddressEntity = $paymentEntity->getSpySalesOrder()->getBillingAddress();

        $personalContainer = new PersonalContainer();
        $this->mapBillingAddressToPersonalContainer($personalContainer, $billingAddressEntity);

        $authorizationContainer->setPersonalData($personalContainer);

        return $authorizationContainer;
    }

    /**
     * @param \Orm\Zed\Payone\Persistence\SpyPaymentPayone $paymentEntity
     *
     * @return \Spryker\Zed\Payone\Business\Api\Request\Container\Authorization\PaymentMethod\DirectDebitContainer
     */
    protected function createPaymentMethodContainerFromPayment(SpyPaymentPayone $paymentEntity)
    {
        $paymentMethodContainer = new DirectDebitContainer();

        $paymentMethodContainer->setIban($paymentEntity->getSpyPaymentPayoneDetail()->getIban());
        $paymentMethodContainer->setBic($paymentEntity->getSpyPaymentPayoneDetail()->getBic());

        return $paymentMethodContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\PayoneGetFileTransfer $getFileTransfer
     *
     * @return \Spryker\Zed\Payone\Business\Api\Request\Container\GetFileContainer
     */
    public function mapGetFile(PayoneGetFileTransfer $getFileTransfer)
    {
        $getFileContainer = new GetFileContainer();

        $getFileContainer->setFileReference($getFileTransfer->getReference());
        $getFileContainer->setFileType(PayoneApiConstants::FILE_TYPE_MANDATE);
        $getFileContainer->setFileFormat(PayoneApiConstants::FILE_FORMAT_PDF);
        $getFileContainer->setLanguage($this->getStandardParameter()->getLanguage());

        return $getFileContainer;
    }

}
