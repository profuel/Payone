<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Payone\Handler;

use Generated\Shared\Transfer\PaymentDetailTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Library\Currency\CurrencyManager;
use Spryker\Shared\Payone\PayoneApiConstants;
use Symfony\Component\HttpFoundation\Request;

class PayoneHandler
{

    const PAYMENT_PROVIDER = 'Payone';

    /**
     * @var array
     */
    protected static $paymentMethods = [
        PaymentTransfer::PAYONE_PRE_PAYMENT => 'prepayment',
    ];

    /**
     * @var array
     */
    protected static $payonePaymentMethodMapper = [
        PaymentTransfer::PAYONE_PRE_PAYMENT => PayoneApiConstants::PAYMENT_METHOD_PREPAYMENT,
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
            ->setPaymentMethod(self::$paymentMethods[$paymentSelection]);
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

        $billingAddress = $quoteTransfer->getBillingAddress();

        $paymentDetailTransfer = new PaymentDetailTransfer();
        // get it from quotaTransfer
        $paymentDetailTransfer->setAmount($quoteTransfer->getTotals()->getGrandTotal());
        $paymentDetailTransfer->setCurrency($this->getCurrency());

        $payonePaymentTransfer
            ->setPaymentMethod(self::$payonePaymentMethodMapper[$paymentSelection])
            ->setReference('TX1000' . rand(0, 10000))
            ->setPaymentDetail($paymentDetailTransfer);

        $quoteTransfer->getPayment()->setPayone(clone $payonePaymentTransfer);
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
