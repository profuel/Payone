<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Payone;

use Generated\Shared\Transfer\PayoneBankAccountCheckTransfer;
use Generated\Shared\Transfer\PayoneCancelRedirectTransfer;
use Generated\Shared\Transfer\PayoneGetFileTransfer;
use Generated\Shared\Transfer\PayoneGetInvoiceTransfer;
use Generated\Shared\Transfer\PayoneGetPaymentDetailTransfer;
use Generated\Shared\Transfer\PayoneManageMandateTransfer;
use Generated\Shared\Transfer\PayonePersonalDataTransfer;
use Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @api
 *
 * @method \Spryker\Client\Payone\PayoneFactory getFactory()
 */
class PayoneClient extends AbstractClient implements PayoneClientInterface
{

    /**
     * @api
     *
     * @return \Spryker\Client\Payone\ClientApi\Request\CreditCardCheck
     */
    public function getCreditCardCheckRequest()
    {
        $defaults = [];
        return $this->getFactory()->createCreditCardCheckCall($defaults)->mapCreditCardCheckData();
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer $statusUpdateTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneTransactionStatusUpdateTransfer
     */
    public function updateStatus(PayoneTransactionStatusUpdateTransfer $statusUpdateTransfer)
    {
        return $this->getFactory()->createZedStub()->updateStatus($statusUpdateTransfer);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\PayoneGetFileTransfer $getFileTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneGetFileTransfer
     */
    public function getFile(PayoneGetFileTransfer $getFileTransfer)
    {
        return $this->getFactory()->createZedStub()->getFile($getFileTransfer);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\PayoneCancelRedirectTransfer $cancelRedirectTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneCancelRedirectTransfer
     */
    public function cancelRedirect(PayoneCancelRedirectTransfer $cancelRedirectTransfer)
    {
        return $this->getFactory()->createZedStub()->cancelRedirect($cancelRedirectTransfer);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\PayonePaymentDirectDebitTransfer $onlinetransferTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneBankAccountCheckTransfer
     */
    public function bankAccountCheck(PayoneBankAccountCheckTransfer $bankAccountCheckTransfer)
    {
        return $this->getFactory()->createZedStub()->bankAccountCheck($bankAccountCheckTransfer);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneManageMandateTransfer
     */
    public function manageMandate(QuoteTransfer $quoteTransfer)
    {
        $manageMandateTransfer = new PayoneManageMandateTransfer();
        $manageMandateTransfer->setBankCountry($quoteTransfer->getPayment()->getPayoneDirectDebit()->getBankcountry());
        $manageMandateTransfer->setBankAccount($quoteTransfer->getPayment()->getPayoneDirectDebit()->getBankaccount());
        $manageMandateTransfer->setBankCode($quoteTransfer->getPayment()->getPayoneDirectDebit()->getBankcode());
        $manageMandateTransfer->setIban($quoteTransfer->getPayment()->getPayoneDirectDebit()->getIban());
        $manageMandateTransfer->setBic($quoteTransfer->getPayment()->getPayoneDirectDebit()->getBic());
        $personalData = new PayonePersonalDataTransfer();
        $customer = $quoteTransfer->getCustomer();
        $billingAddress = $quoteTransfer->getBillingAddress();
        $personalData->setCustomerId($customer->getIdCustomer());
        $personalData->setLastName($billingAddress->getLastName());
        $personalData->setFirstName($billingAddress->getFirstName());
        $personalData->setCompany($billingAddress->getCompany());
        $personalData->setCountry($billingAddress->getIso2Code());
        $personalData->setCity($billingAddress->getCity());
        $personalData->setStreet($billingAddress->getAddress1());
        $personalData->setZip($billingAddress->getZipCode());
        $personalData->setEmail($billingAddress->getEmail());
        $manageMandateTransfer->setPersonalData($personalData);

        return $this->getFactory()->createZedStub()->manageMandate($manageMandateTransfer);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\PayoneGetPaymentDetailTransfer $getPaymentDetailTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneGetPaymentDetailTransfer
     */
    public function getPaymentDetail(PayoneGetPaymentDetailTransfer $getPaymentDetailTransfer)
    {
        return $this->getFactory()->createZedStub()->getPaymentDetail($getPaymentDetailTransfer);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\PayoneGetInvoiceTransfer $getInvoiceTransfer
     *
     * @return \Generated\Shared\Transfer\PayoneGetInvoiceTransfer
     */
    public function getInvoice(PayoneGetInvoiceTransfer $getInvoiceTransfer)
    {
        return $this->getFactory()->createZedStub()->getInvoice($getInvoiceTransfer);
    }

}
