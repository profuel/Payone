<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Handler;

use Generated\Shared\Transfer\PaymentDetailTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\PayonePaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Library\Currency\CurrencyManager;
use Spryker\Shared\Payone\PayoneApiConstants;
use Symfony\Component\HttpFoundation\Request;

class PayoneHandler
{

    const PAYMENT_PROVIDER = 'Payone';
    const CHECKOUT_PARTIAL_SUMMARY_PATH = 'Payone/partial/summary';

    /**
     * @var array
     */
    protected static $paymentMethods = [
        PaymentTransfer::PAYONE_CREDIT_CARD => 'credit_card',
        PaymentTransfer::PAYONE_E_WALLET => 'e_wallet',
        PaymentTransfer::PAYONE_DIRECT_DEBIT => 'direct_debit',
    ];

    /**
     * @var array
     */
    protected static $payonePaymentMethodMapper = [
        PaymentTransfer::PAYONE_CREDIT_CARD => PayoneApiConstants::PAYMENT_METHOD_CREDITCARD,
        PaymentTransfer::PAYONE_E_WALLET => PayoneApiConstants::PAYMENT_METHOD_E_WALLET,
        PaymentTransfer::PAYONE_DIRECT_DEBIT => PayoneApiConstants::PAYMENT_METHOD_DIRECT_DEBIT,
    ];

    /**
     * @var array
     */
    protected static $payoneGenderMapper = [
        'Mr' => 'Male',
        'Mrs' => 'Female',
    ];


    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function addPaymentToQuote(Request $request, QuoteTransfer $quoteTransfer)
    {
        $paymentSelection = $quoteTransfer->getPayment()->getPaymentSelection();

        $this->setPaymentProviderAndMethod($quoteTransfer, $paymentSelection);
        $this->setPayonePayment($request, $quoteTransfer, $paymentSelection);

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param string $paymentSelection
     *
     * @return void
     */
    protected function setPaymentProviderAndMethod(QuoteTransfer $quoteTransfer, $paymentSelection)
    {
        $quoteTransfer->getPayment()
            ->setPaymentProvider(self::PAYMENT_PROVIDER)
            ->setPaymentMethod(self::$payonePaymentMethodMapper[$paymentSelection]);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    protected function setPaymentSuccessPartialPath(QuoteTransfer $quoteTransfer)
    {
        $quoteTransfer->requirePayment()->getPayment()->setSummaryPartialPath(self::CHECKOUT_PARTIAL_SUMMARY_PATH);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param string $paymentSelection
     *
     * @return void
     */
    protected function setPayonePayment(Request $request, QuoteTransfer $quoteTransfer, $paymentSelection)
    {
        $payonePaymentTransfer = $this->getPayonePaymentTransfer($quoteTransfer, $paymentSelection);

        $paymentDetailTransfer = new PaymentDetailTransfer();
        // get it from quotaTransfer
        $paymentDetailTransfer->setAmount($quoteTransfer->getTotals()->getGrandTotal());
        $paymentDetailTransfer->setCurrency($this->getCurrency());
        if ($paymentSelection == PaymentTransfer::PAYONE_CREDIT_CARD) {
            $paymentDetailTransfer->setPseudoCardPan($payonePaymentTransfer->getPseudocardpan());
        } elseif ($paymentSelection == PaymentTransfer::PAYONE_E_WALLET) {
            $paymentDetailTransfer->setType($payonePaymentTransfer->getWallettype());
        } elseif ($paymentSelection == PaymentTransfer::PAYONE_DIRECT_DEBIT) {
            $paymentDetailTransfer->setMandateIdentification($payonePaymentTransfer->getMandateIdentification());
            $paymentDetailTransfer->setMandateText($payonePaymentTransfer->getMandateText());
        }

        $quoteTransfer->getPayment()->setPayone(new PayonePaymentTransfer());
        $quoteTransfer->getPayment()->getPayone()->setReference(uniqid('TX1'));
        $quoteTransfer->getPayment()->getPayone()->setPaymentDetail($paymentDetailTransfer);
        $quoteTransfer->getPayment()->getPayone()->setPaymentMethod($quoteTransfer->getPayment()->getPaymentMethod());
    }


    /**
     * @return string
     */
    protected function getCurrency()
    {
        return CurrencyManager::getInstance()->getDefaultCurrency()->getIsoCode();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param string $paymentSelection
     *
     * @return \Generated\Shared\Transfer\PayonePaymentTransfer
     */
    protected function getPayonePaymentTransfer(QuoteTransfer $quoteTransfer, $paymentSelection)
    {
        $method = 'get' . ucfirst($paymentSelection);
        $payonePaymentTransfer = $quoteTransfer->getPayment()->$method();

        return $payonePaymentTransfer;
    }

}
